import http from "k6/http";
import { check, group, sleep } from "k6";

const BASE_URL = __ENV.BASE_URL || "http://localhost";
const USER_EMAIL = __ENV.USER_EMAIL || "test@example.com";
const USER_PASSWORD = __ENV.USER_PASSWORD || "12121212";

export const options = {
    stages: [
        { duration: "10s", target: 5 },
        { duration: "20s", target: 10 },
        { duration: "10s", target: 0 },
    ],
    thresholds: {
        http_req_failed: ["rate<0.1"],
        http_req_duration: ["p(95)<4000"],
    },
};

function extractCsrfToken(html) {
    const match = html.match(/name="_token"\s+value="([^"]+)"/);
    return match ? match[1] : null;
}

function escapeRegExp(value) {
    return value.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
}

function findPostIdByTitle(html, title) {
    const safeTitle = escapeRegExp(title);
    const regex = new RegExp(`/posts/(\\d+)[\\s\\S]*?${safeTitle}`);
    const match = html.match(regex);
    return match ? match[1] : null;
}

export default function () {
    let loginOk = false;
    let createdPostId = null;
    let createdPostTitle = null;

    group("Guest buka homepage", () => {
        const res = http.get(`${BASE_URL}/`);
        check(res, {
            "homepage status 200": (r) => r.status === 200,
            "homepage has posts list": (r) => r.body.includes("/posts/"),
        });
    });

    sleep(1);

    group("Login", () => {
        const loginPage = http.get(`${BASE_URL}/login`);
        const csrfToken = extractCsrfToken(loginPage.body);

        const hasToken = check(loginPage, {
            "login page status 200": (r) => r.status === 200,
            "login page has csrf": () => csrfToken !== null,
        });

        if (!hasToken || !csrfToken) {
            return;
        }

        const loginRes = http.post(
            `${BASE_URL}/login`,
            {
                email: USER_EMAIL,
                password: USER_PASSWORD,
                _token: csrfToken,
            },
            { redirects: 0 },
        );

        loginOk = check(loginRes, {
            "login success (302 or 200)": (r) =>
                r.status === 302 || r.status === 200,
        });
    });

    if (!loginOk) {
        return;
    }

    sleep(1);

    group("Melihat daftar post", () => {
        const res = http.get(`${BASE_URL}/`);
        check(res, {
            "list posts status 200": (r) => r.status === 200,
            "list posts has link": (r) => r.body.includes("/posts/"),
        });
    });

    sleep(1);

    group("Membuat post", () => {
        const createPage = http.get(`${BASE_URL}/posts/create`);
        const csrfToken = extractCsrfToken(createPage.body);

        const hasToken = check(createPage, {
            "create page status 200": (r) => r.status === 200,
            "create page has csrf": () => csrfToken !== null,
        });

        if (!hasToken || !csrfToken) {
            return;
        }

        const title = `K6 Post ${__VU}-${__ITER}-${Date.now()}`;
        const content = "Post dibuat oleh k6 untuk stress test.";

        const createRes = http.post(
            `${BASE_URL}/posts`,
            {
                title,
                content,
                _token: csrfToken,
            },
            { redirects: 0 },
        );

        check(createRes, {
            "create post redirect": (r) => r.status === 302,
        });

        createdPostTitle = title;

        const listRes = http.get(`${BASE_URL}/`);
        createdPostId = findPostIdByTitle(listRes.body, createdPostTitle);
    });

    sleep(1);

    group("Membaca post", () => {
        const listRes = http.get(`${BASE_URL}/`);
        const fallbackMatch = listRes.body.match(/\/posts\/(\d+)/);
        const postId =
            createdPostId || (fallbackMatch ? fallbackMatch[1] : null);

        const hasPost = check(listRes, {
            "list for read status 200": (r) => r.status === 200,
            "list contains post id": () => postId !== null,
        });

        if (!hasPost || !postId) {
            return;
        }

        const showRes = http.get(`${BASE_URL}/posts/${postId}`);
        check(showRes, {
            "show post status 200": (r) => r.status === 200,
        });
    });

    sleep(1);

    group("Menghapus post", () => {
        if (!createdPostId) {
            return;
        }

        const editPage = http.get(`${BASE_URL}/posts/${createdPostId}/edit`);
        const csrfToken = extractCsrfToken(editPage.body);

        const hasToken = check(editPage, {
            "edit page status 200": (r) => r.status === 200,
            "edit page has csrf": () => csrfToken !== null,
        });

        if (!hasToken || !csrfToken) {
            return;
        }

        const deleteRes = http.post(
            `${BASE_URL}/posts/${createdPostId}`,
            {
                _token: csrfToken,
                _method: "DELETE",
            },
            { redirects: 0 },
        );

        check(deleteRes, {
            "delete post redirect": (r) => r.status === 302,
        });
    });

    sleep(1);
}

import request from "@/utils/request";

export function ApiGetList(page) {
    return request.get('api/short-link', {params: {page: page}});
}

export function ApiAddList(link, state) {
    return request.post('api/short-link', {
        link: link,
        state: state,
    });
}

export function ApiEditList(linkId, link, state) {
    return request.put('api/short-link/' + linkId, {
        link: link,
        state: state,
    });
}

export function ApiDeleteList(link) {
    return request.delete('api/short-link/' + link);
}

export function ApiLinkClick(code, referrer, ip) {
    return request.post('api/short-link/visit/' + code, {
        referrer: referrer,
        ip: ip
    });
}

import {ApiAddList, ApiDeleteList, ApiEditList, ApiGetList, ApiLinkClick} from "@/api/Links";
import axios from 'axios'

class LinksService {
    list(page) {
        return ApiGetList(page)
    }

    add(data) {
        return ApiAddList(data.link, data.state)
    }

    edit(link, data) {
        return ApiEditList(link.id, data.link, data.state)
    }

    delete(item) {
        return ApiDeleteList(item)
    }

    visit(code, referrer, ip) {
        return ApiLinkClick(code, referrer, ip)
    }
}

export default new LinksService()

class NZUtils {
    static VERSION = '1.0';

    constructor() {
    }

    get VERSION() {
        return NZUtils.VERSION;
    }

    static editUrlParam(key, value) {
        if (history.replaceState) {
            let searchParams = new URLSearchParams(window.location.search);
            searchParams.set(key, value);
            let newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + searchParams.toString();
            window.history.replaceState({path: newurl}, '', newurl);
        }else {
            alert('unsuported');
        }
    }

    static insertUrlParam(key, value) {
        NZUtils.editUrlParam(key, value);
    }
}
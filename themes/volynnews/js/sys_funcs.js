"use strict";

window.sys_funcs = {

    responceStatus: function(aData) {
        if (aData.status && aData.status == 'ok')
            return true;

        return false;
    },

    responceGetError: function(aData) {
        var lError = 'Status is missing. Undefined error';
        if (!aData.status)
            return lError;

        if (aData.status != 'error')
            return 'Status is not error';

        if (!aData.code)
            return 'Status Error. Error code is missing. Undefined error';

        return aData.code;
    },
}

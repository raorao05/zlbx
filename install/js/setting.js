/* ��ʼ��һЩȫ�ֱ��� */
var lf = "<br />";
var iframe = null;
var notice = null;
var oriDisabledInputs = [];

/* Ajax���� */
Ajax.onRunning = null;
Ajax.onComplete = null;

/**
 * ��ʾ���ݿ��б�
 */
function displayDbList() {
    var f = $("js-setting"), dbList = f["js-db-list"];

    dbList.onchange = function () {
        f["js-db-name"].value = dbList.options[dbList.selectedIndex].value;
        f["js-db-name"].focus();
    };

    var opts = getDbList(),
        opt;
    if (opts !== false) {
        dbList.options.length = 1;
        var num = opts.length,
            text = $_LANG['total_num'].replace("%s", num);
        dbList[0] = new Option(text, "", false, false);
        for (var i = 0; i < num; i++) {
            opt = new Option(opts[i], opts[i], false, false);
            dbList[dbList.options.length] = opt;
        }
    }
}

/**
 * ������ݿ��б�
 */
function getDbList() {
    var f = $("js-setting"),
        params="db_host=" + f["js-db-host"].value + "&"
            + "db_port=" + f["js-db-port"].value + "&"
            + "db_user=" + encodeURIComponent(f["js-db-user"].value) + "&"
            + "db_pass=" + encodeURIComponent(f["js-db-pass"].value) + "&"
            + "lang=" + getAddressLang() + "&"
            + "IS_AJAX_REQUEST=yes";
    try {
        var result = Ajax.call("./index.php?step=get_db_list", params, null, "POST", "JSON", false);
    } catch (ex) {
        //alert(ex);
    }

    if (typeof(result) === "object" && result["msg"] === "OK") {
        return result["list"].split(",");
    } else {
        alert(result);
        return false;
    }
}

/**
 * �л���ѡ���״̬
 */
function switchInputsStatus() {
    var goodsTypes = document.getElementsByName("js-goods-type[]"),
        num = goodsTypes.length;

    if (this.checked) {
        for (var i = 0; i < num; i++) {
            goodsTypes[i].checked = "checked";
            goodsTypes[i].disabled = "true";
        }
    } else {
        for (var i = 0; i < num; i++) {
            goodsTypes[i].checked = "";
            goodsTypes[i].disabled = "";
        }
    }
}

/**
 * ��װ����������
 */
function install() {
    lockAllInputs();
    startNotice();
    $("js-install-at-once").setAttribute("disabled", "true");
    $("js-monitor").style.display = "block";
    try {
        createConfigFile();
    } catch (ex) {
    }
}

/**
 * ���������ļ�
 */
function createConfigFile() {
    var f = $("js-setting"),
        tzs = f["js-timezones"],
        tz = tzs ? "timezone=" + tzs[tzs.selectedIndex].value : "",
        params="db_host=" + f["js-db-host"].value + "&"
            + "db_port=" + f["js-db-port"].value + "&"
            + "db_user=" + encodeURIComponent(f["js-db-user"].value) + "&"
            + "db_pass=" + encodeURIComponent(f["js-db-pass"].value) + "&"
            + "db_name=" + encodeURIComponent(f["js-db-name"].value) + "&"
            + "db_prefix=" + f["js-db-prefix"].value + "&"
            + tz + "&"
            + "lang=" + getAddressLang() + "&"
            + "IS_AJAX_REQUEST=yes";

    notice.innerHTML = $_LANG["create_config_file"];

    Ajax.call("./index.php?step=create_config_file", params, function (result) {
        if (result.replace(/\s+$/g, '') === "OK") {
            displayOKMsg();
            createDatabase();
        } else {
            displayErrorMsg(result);
        }
    });
}

/**
 * ��ʼ�����ݿ�
 */
function createDatabase() {
    var f = $("js-setting"),
        params="db_host=" + f["js-db-host"].value + "&"
            + "db_port=" + f["js-db-port"].value + "&"
            + "db_user=" + encodeURIComponent(f["js-db-user"].value) + "&"
            + "db_pass=" + encodeURIComponent(f["js-db-pass"].value) + "&"
            + "db_name=" + encodeURIComponent(f["js-db-name"].value) + "&"
            + "lang=" + getAddressLang();

    notice.innerHTML += $_LANG["create_database"];

    Ajax.call("./index.php?step=create_database", params, function (result) {
        if (result.replace(/\s+$/g, '') === "OK") {
            displayOKMsg();
            installBaseData();
        } else {
            displayErrorMsg(result);
        }
    });
}

/**
 * ��װ����
 */
function installBaseData() {
    var f = $("js-setting"),
        params = "system_lang=" + getCheckedRadio("js-system-lang").value + "&"
            + "lang=" + getAddressLang();

    notice.innerHTML += $_LANG["install_data"];

    Ajax.call("./index.php?step=install_base_data", params, function (result) {
        if (result.replace(/\s+$/g, '') === "OK") {
            displayOKMsg();
            createAdminPassport();
        } else {
            displayErrorMsg(result);
        }
    });
}

/**
 * ��������Ա�ʺ�
 */
function createAdminPassport() {
    var f = $("js-setting"),
        params="admin_name=" + encodeURIComponent(f["js-admin-name"].value) + "&"
            + "admin_password=" + encodeURIComponent(f["js-admin-password"].value) + "&"
            + "admin_password2=" + encodeURIComponent(f["js-admin-password2"].value) + "&"
            + "admin_email=" + f["js-admin-email"].value + "&"
            + "lang=" + getCheckedRadio("js-system-lang").value;

    notice.innerHTML += $_LANG["create_admin_passport"];

    Ajax.call("./index.php?step=create_admin_passport", params, function (result) {
        if (result.replace(/\s+$/g, '') === "OK") {
            displayOKMsg();
            doOthers();
        } else {
            displayErrorMsg(result);
        }
    });
}

/**
 * ���������Ĳ���
 */
function doOthers() {
    var f = $("js-setting"),
        disableCaptcha = f["js-disable-captcha"].checked ? 0 : 1,
        installDemo = f["js-install-demo"].checked ? 1 : 0,
        params = "disable_captcha=" + disableCaptcha + "&"
            + "system_lang=" + getCheckedRadio("js-system-lang").value + "&"
            + getCheckedGoodsTypesString() + "&"
            + "install_demo=" + installDemo + "&"
            + "userinterface=" + f["userinterface"].value + "&"
            + "lang=" + getAddressLang();

    notice.innerHTML += $_LANG["do_others"];

    Ajax.call("./index.php?step=do_others", params, function (result) {
        if (result.replace(/\s+$/g, '') === "OK") {
            displayOKMsg();
            goToDone();
        } else {
            displayErrorMsg(result);
        }
    });
}

/**
 * ת�����ҳ
 */
function goToDone() {
    stopNotice();
    window.setTimeout(function () {
        location.href = "./index.php?lang=" + getAddressLang() + "&step=done";
    }, 1000);
}

/* �ڰ�װ�����е��ø÷��� */
function startNotice() {
    $("js-monitor-loading").src = "images/loading.gif";
    $("js-monitor-wait-please").innerHTML = "<strong style='color:blue'>" + $_LANG["wait_please"] + "</strong>";
};

/* ��װ��ϵ��ø÷��� */
function stopNotice() {
    $("js-monitor-loading").src = "images/loading2.gif";
    $("js-monitor-wait-please").innerHTML = $_LANG["has_been_stopped"];
};

/**
 * ȡ������ѡ�еĸ�ѡ��
 */
function getCheckedBoxes(boxName) {
    var boxes = document.getElementsByName(boxName),
        num = boxes.length,
        checkedBoxes = [];

    for (var i = 0; i < num; i++) {
        if (boxes[i].checked) {
            checkedBoxes.push(boxes[i]);
        }
    }

    return checkedBoxes;
}

/**
 * ȡ��ѡ�����Ʒ���ʹ�
 */
function getCheckedGoodsTypesString() {
    var f = $("js-setting"),
        checkedGoodsTypes = getCheckedBoxes("js-goods-type[]"),
        num = checkedGoodsTypes.length,
        gtString = '';

    for (var i = 0; i < num; i++) {
            gtString += "goods_types[]=" + checkedGoodsTypes[i].value + '&';
    }
    gtString = gtString.replace(/&$/, "");

    return gtString;
}

/**
 * ���ѡ�еĵ�ѡ��
 */
function getCheckedRadio(radioName) {
    var radios = document.getElementsByName(radioName);
    for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            return radios[i];
        }
    }
}

/**
 * �������е��������
 */
function lockAllInputs() {
    recOriDisabledInputs();
    var elems = $("js-setting").elements;
    for (var i = 0; i < elems.length; i++) {
        elems[i].disabled = "true";
    }
}

/**
 * ����ĳЩ�������
 */
function unlockSpecInputs() {
    var elems = $("js-setting").elements;
    for (var i = 0; i < elems.length; i++) {
        if (oriDisabledInputs.inArray(elems[i]))  {
            continue;
        }
        elems[i].removeAttribute("disabled");
    }
}

/**
 * ��¼��Щԭ�Ⱦͱ��������������
 */
function recOriDisabledInputs() {
    var elems = $("js-setting").elements;
    for (var i = 0; i < elems.length; i++) {
       if (elems[i].disabled) {
            oriDisabledInputs.push(elems[i]);
       }
    }
}

/**
 * �������ԭ�Ͷ���һ���������ж�Ԫ���ǲ�������ĳ������
 */
Array.prototype.inArray = function (unit) {
    var length = this.length;
    for (var i = 0; i < length; i++) {
        if (unit === this[i])  {
            return true;
        }
    }
    return false;
}

/**
 * ��ʾ�����Ϣ
 */
function displayOKMsg() {
    notice.innerHTML += "<span style='color:green;'>" + $_LANG["success"] + "</span>" + lf;
}

/**
 * ��ʾ������Ϣ
 */
function displayErrorMsg(result) {
    stopNotice();
    notice.innerHTML += "<span style='color:red;'>" +  $_LANG["fail"]  + "</span>" + lf + lf;
    $("js-monitor-view-detail"). innerHTML = $_LANG["hide_detail"];
    $("js-monitor-notice").style.display = "block";
    notice.innerHTML += "<strong style='color:red'>" + result + "</strong>";
}

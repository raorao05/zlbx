/* ��ʼ��һЩȫ�ֱ��� */
var lf = "<br />";
var iframe = null;
var notice = null;
var oriDisabledInputs = [];

/* Ajax���� */
Ajax.onRunning = null;
Ajax.onComplete = null;

/* ҳ�������ϣ�ִ��һЩ���� */
window.onload = function () {
    setInputCheckedStatus();
    var f = $("js-setup");
    var ucinstalloptions = document.getElementsByName("ucinstall");


    $("js-pre-step").onclick = function() {
        location.href="./index.php?lang=" + getAddressLang() + "&step=welcome";
    };

    $("js-submit").onclick = function () {
        setupUCenter();
    }

    var ui_1 = $('user_interface_1');
    var ui_2 = $('user_interface_2');

    if (ui_1)
    {
        ui_1.onclick = function ()
        {
            if (this.checked === true)
            {
                $('ucenter').style.display = 'none';
            }
        }
    }
    if (ui_2)
    {
        ui_2.onclick = function ()
        {
            if (this.checked === true)
            {
                $('ucenter').style.display = '';
            }
        }
    }

    user_interface_init(ui_1);
};

/**
 * ����Ucenter
 */
function setupUCenter()
{
   var f = $("js-setup");
   if ($('user_interface_1').checked === true)
   {
       f.action = "index.php?lang=" + getAddressLang() + "&step=check";
       f.submit();
   }
   var ucinstalloptions = document.forms['js-setup'].ucinstall;
   var uccheck = true;


   if(f["js-ucapi"].value.length < 1)
   {
       $("ucapinotice").innerHTML='����дUCenter��URL';
        uccheck = false;
   }
   else
   {
        $("ucapinotice").innerHTML='';
   }

    if(f["js-ucip"] && f["js-ucip"].value.length < 1) {
        $("ucipnotice").innerHTML='����дUCenter��IP';
        uccheck = false;
    }
    
    if (f['js-ucfounderpw'].value.length < 1)
    {
        $("ucfounderpwnotice").innerHTML='����д UCenter ��ʼ�˵�����';
        uccheck = false;
    }
    else
    {
        $("ucfounderpwnotice").innerHTML='';
    }

    if(uccheck == false)
    {
        return uccheck;
    }
    if(f["js-ucip"] && f["js-ucip"].value.length > 1) {
        var params="ucapi=" + encodeURIComponent(f["js-ucapi"].value) + "&" + "ucfounderpw=" + encodeURIComponent(f["js-ucfounderpw"].value)+"&"+"ucip="+encodeURIComponent(f["js-ucip"].value);
    } else {
        var params="ucapi=" + encodeURIComponent(f["js-ucapi"].value) + "&" + "ucfounderpw=" + encodeURIComponent(f["js-ucfounderpw"].value);
    }
    
    Ajax.call("./index.php?step=setup_ucenter", params, displayres, 'POST', 'JSON');

}

function displayres(res)
{
    if (res.error !== 0)
    {
        $("ucfounderpwnotice").innerHTML= res.message;
        if(res.error == 2) {
            var td1 = document.createElement("TD");
            var td2 = document.createElement("TD");
            td1.innerHTML = 'UCenter �� IP��';
            td1.setAttribute('width', 200);td1.setAttribute('align', 'right');
            td2.innerHTML = '<input name=\"js-ucip\" type=\"text\" id=\"js-ucip\"  value=\"\" size=\"40\" /><span id=\"ucipnotice\" style=\"color:#FF0000\">���ӵĹ����г��˵����⣬������д������ IP ��ַ��������� UC �� ECShop װ��ͬһ�������ϣ����ǽ�����������д 127.0.0.1</span>';
            $("ucip").appendChild(td1);
            $("ucip").appendChild(td2);
        }
        
    }
    else
    {
    	var ui = ($('user_interface_1').checked === true)?$('user_interface_1').value:$('user_interface_2').value;
        location.href="index.php?lang=" + getAddressLang() + "&step=check" + "&ui="+ui;
    }
}

function user_interface_init(obj)
{
    if (obj.checked === true)
    {
        $('ucenter').style.display = 'none';
    }
    else
    {
        $('ucenter').style.display = '';
    }
}

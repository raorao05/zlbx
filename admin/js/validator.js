/* *
 * ECSHOP ����֤��
 * ============================================================================
 * ��Ȩ���� (C) 2005-2011 ��ʢ���루�������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ : http : // www.ecshop.com
 * ----------------------------------------------------------------------------
 * ����һ����ѿ�Դ�����������ζ���������ڲ�������ҵĿ�ĵ�ǰ���¶Գ������
 * �����޸ĺ��ٷ�����
 * ============================================================================
 * $Author : paulgao $
 * $Date : 2007-01-31 16:23:56 +0800 (������, 31 һ�� 2007) $
 * $Id : validator.js 4824 2007-01-31 08:23:56Z paulgao $

 *//* *
 * ����֤��
 *
 * @author : weber liu
 * @version : v1.1
 */

var Validator = function(name)
{
  this.formName = name;
  this.errMsg = new Array();

  /* *
  * ����û��Ƿ�����������
  *
  * @param :  controlId   ��Ԫ�ص�ID
  * @param :  msg         ������ʾ��Ϣ
  */
  this.required = function(controlId, msg)
  {
    var obj = document.forms[this.formName].elements[controlId];
    if (typeof(obj) == "undefined" || Utils.trim(obj.value) == "")
    {
      this.addErrorMsg(msg);
    }
  }
  ;

  /* *
  * ����û�������Ƿ�Ϊ�Ϸ����ʼ���ַ
  *
  * @param :  controlId   ��Ԫ�ص�ID
  * @param :  msg         ������ʾ��Ϣ
  * @param :  required    �Ƿ����
  */
  this.isEmail = function(controlId, msg, required)
  {
    var obj = document.forms[this.formName].elements[controlId];
    obj.value = Utils.trim(obj.value);

    if ( ! required && obj.value == '')
    {
      return;
    }

    if ( ! Utils.isEmail(obj.value))
    {
      this.addErrorMsg(msg);
    }
  }

  /* *
  * ���������Ԫ�ص�ֵ�Ƿ����
  *
  * @param : fstControl   ��Ԫ�ص�ID
  * @param : sndControl   ��Ԫ�ص�ID
  * @param : msg         ������ʾ��Ϣ
  */
  this.eqaul = function(fstControl, sndControl, msg)
  {
    var fstObj = document.forms[this.formName].elements[fstControl];
    var sndObj = document.forms[this.formName].elements[sndControl];

    if (fstObj != null && sndObj != null)
    {
      if (fstObj.value == '' || fstObj.value != sndObj.value)
      {
        this.addErrorMsg(msg);
      }
    }
  }

  /* *
  * ���ǰһ����Ԫ���Ƿ���ں�һ����Ԫ��
  *
  * @param : fstControl   ��Ԫ�ص�ID
  * @param : sndControl   ��Ԫ�ص�ID
  * @param : msg                ������ʾ��Ϣ
  */
  this.gt = function(fstControl, sndControl, msg)
  {
    var fstObj = document.forms[this.formName].elements[fstControl];
    var sndObj = document.forms[this.formName].elements[sndControl];

    if (fstObj != null && sndObj != null) {
      if (Utils.isNumber(fstObj.value) && Utils.isNumber(sndObj.value)) {
        var v1 = parseFloat(fstObj.value) + 0;
        var v2 = parseFloat(sndObj.value) + 0;
      } else {
        var v1 = fstObj.value;
        var v2 = sndObj.value;
      }

      if (v1 <= v2) this.addErrorMsg(msg);
    }
  }

  /* *
  * �������������Ƿ���һ������
  *
  * @param :  controlId   ��Ԫ�ص�ID
  * @param :  msg         ������ʾ��Ϣ
  * @param :  required    �Ƿ����
  */
  this.isNumber = function(controlId, msg, required)
  {
    var obj = document.forms[this.formName].elements[controlId];
    obj.value = Utils.trim(obj.value);

    if (obj.value == '' && ! required)
    {
      return;
    }
    else
    {
      if ( ! Utils.isNumber(obj.value))
      {
        this.addErrorMsg(msg);
      }
    }
  }

  /* *
  * �������������Ƿ���һ������
  *
  * @param :  controlId   ��Ԫ�ص�ID
  * @param :  msg         ������ʾ��Ϣ
  * @param :  required    �Ƿ����
  */
  this.isInt = function(controlId, msg, required)
  {

    if (document.forms[this.formName].elements[controlId])
    {
      var obj = document.forms[this.formName].elements[controlId];
    }
    else
    {
      return;    
    }

    obj.value = Utils.trim(obj.value);

    if (obj.value == '' && ! required)
    {
      return;
    }
    else
    {
      if ( ! Utils.isInt(obj.value)) this.addErrorMsg(msg);
    }
  }

  /* *
  * �������������Ƿ���Ϊ��
  *
  * @param :  controlId   ��Ԫ�ص�ID
  * @param :  msg         ������ʾ��Ϣ
  * @param :  required    �Ƿ����
  */
  this.isNullOption = function(controlId, msg)
  {
    var obj = document.forms[this.formName].elements[controlId];

    obj.value = Utils.trim(obj.value);

    if (obj.value > '0' )
    {
      return;
    }
    else
    {
      this.addErrorMsg(msg);
    }
  }

  /* *
  * �������������Ƿ���"2006-11-12 12:00:00"��ʽ
  *
  * @param :  controlId   ��Ԫ�ص�ID
  * @param :  msg         ������ʾ��Ϣ
  * @param :  required    �Ƿ����
  */
  this.isTime = function(controlId, msg, required)
  {
    var obj = document.forms[this.formName].elements[controlId];
    obj.value = Utils.trim(obj.value);

    if (obj.value == '' && ! required)
    {
      return;
    }
    else
    {
      if ( ! Utils.isTime(obj.value)) this.addErrorMsg(msg);
    }
  }
  
  /* *
  * ���ǰһ����Ԫ���Ƿ�С�ں�һ����Ԫ��(�����ж�)
  *
  * @param : controlIdStart   ��Ԫ�ص�ID
  * @param : controlIdEnd     ��Ԫ�ص�ID
  * @param : msg              ������ʾ��Ϣ
  */
  this.islt = function(controlIdStart, controlIdEnd, msg)
  {
    var start = document.forms[this.formName].elements[controlIdStart];
    var end = document.forms[this.formName].elements[controlIdEnd];
    start.value = Utils.trim(start.value);
    end.value = Utils.trim(end.value);

    if(start.value <= end.value)
    {
      return;
    }
    else
    {
      this.addErrorMsg(msg);
    }
  }

  /* *
  * ���ָ����checkbox�Ƿ�ѡ��
  *
  * @param :  controlId   ��Ԫ�ص�name
  * @param :  msg         ������ʾ��Ϣ
  */
  this.requiredCheckbox = function(chk, msg)
  {
    var obj = document.forms[this.formName].elements[controlId];
    var checked = false;

    for (var i = 0; i < objects.length; i ++ )
    {
      if (objects[i].type.toLowerCase() != "checkbox") continue;
      if (objects[i].checked)
      {
        checked = true;
        break;
      }
    }

    if ( ! checked) this.addErrorMsg(msg);
  }

  this.passed = function()
  {
    if (this.errMsg.length > 0)
    {
      var msg = "";
      for (i = 0; i < this.errMsg.length; i ++ )
      {
        msg += "- " + this.errMsg[i] + "\n";
      }

      alert(msg);
      return false;
    }
    else
    {
      return true;
    }
  }

  /* *
  * ����һ��������Ϣ
  *
  * @param :  str
  */
  this.addErrorMsg = function(str)
  {
    this.errMsg.push(str);
  }
}

/* *
 * ������Ϣ����������
 */
function showNotice(objId)
{
  var obj = document.getElementById(objId);

  if (obj)
  {
    if (obj.style.display != "block")
    {
      obj.style.display = "block";
    }
    else
    {
      obj.style.display = "none";
    }
  }
}

/* *
 * add one option of a select to another select.
 *
 * @author  Chunsheng Wang < wwccss@263.net >
 */
function addItem(src, dst)
{
  for (var x = 0; x < src.length; x ++ )
  {
    var opt = src.options[x];
    if (opt.selected && opt.value != '')
    {
      var newOpt = opt.cloneNode(true);
      newOpt.className = '';
      newOpt.text = newOpt.innerHTML.replace(/^\s+|\s+$|&nbsp;/g, '');
      dst.appendChild(newOpt);
    }
  }

  src.selectedIndex = -1;
}

/* *
 * move one selected option from a select.
 *
 * @author  Chunsheng Wang < wwccss@263.net >
 */
function delItem(ItemList)
{
  for (var x = ItemList.length - 1; x >= 0; x -- )
  {
    var opt = ItemList.options[x];
    if (opt.selected)
    {
      ItemList.options[x] = null;
    }
  }
}

/* *
 * join items of an select with ",".
 *
 * @author  Chunsheng Wang < wwccss@263.net >
 */
function joinItem(ItemList)
{
  var OptionList = new Array();
  for (var i = 0; i < ItemList.length; i ++ )
  {
    OptionList[OptionList.length] = ItemList.options[i].text + "|" + ItemList.options[i].value;
  }
  return OptionList.join(",");
}

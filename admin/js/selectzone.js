/* $Id : selectzone.js 4824 2007-01-31 08:23:56Z paulgao $ */

/* *
 * SelectZone ��
 */
function SelectZone()
{
  this.filters   = new Object();

  this.id        = arguments[0] ? arguments[0] : 1;     // ��������
  this.sourceSel = arguments[1] ? arguments[1] : null;  // 1 ��Ʒ���� 2 ��ϡ���Ʒ�����۸�
  this.targetSel = arguments[2] ? arguments[2] : null;  // Դ   select ����
  this.priceObj  = arguments[3] ? arguments[3] : null;  // Ŀ�� select ����

  this.filename  = location.href.substring((location.href.lastIndexOf("/")) + 1, location.href.lastIndexOf("?")) + "?is_ajax=1";
  var _self = this;

  /**
   * ����Դselect�����options
   * @param   string      funcName    ajax��������
   * @param   function    response    ������
   */
  this.loadOptions = function(act, filters)
  {
    Ajax.call(this.filename+"&act=" + act, filters, this.loadOptionsResponse, "GET", "JSON");
  }

  /**
   * �����ص����ݽ���Ϊoptions����ʽ
   * @param   result      ���ص�����
   */
  this.loadOptionsResponse = function(result, txt)
  {
    if (!result.error)
    {
      _self.createOptions(_self.sourceSel, result.content);
    }

    if (result.message.length > 0)
    {
      alert(result.message);
    }
    return;
  }

  /**
   * ������
   * @return boolean
   */
  this.check = function()
  {
    /* source select */
    if ( ! this.sourceSel)
    {
      alert('source select undefined');
      return false;
    }
    else
    {
      if (this.sourceSel.nodeName != 'SELECT')
      {
        alert('source select is not SELECT');
        return false;
      }
    }

    /* target select */
    if ( ! this.targetSel)
    {
      alert('target select undefined');
      return false;
    }
    else
    {
      if (this.targetSel.nodeName != 'SELECT')
      {
        alert('target select is not SELECT');
        return false;
      }
    }

    /* price object */
    if (this.id == 2 && ! this.priceObj)
    {
      alert('price obj undefined');
      return false;
    }

    return true;
  }

  /**
   * ���ѡ����
   * @param   boolean  all
   * @param   string   act
   * @param   mix      arguments   �����������±��[2]��ʼ
   */
  this.addItem = function(all, act)
  {
    if (!this.check())
    {
      return;
    }

    var selOpt  = new Array();

    for (var i = 0; i < this.sourceSel.length; i ++ )
    {
      if (!this.sourceSel.options[i].selected && all == false) continue;

      if (this.targetSel.length > 0)
      {
        var exsits = false;
        for (var j = 0; j < this.targetSel.length; j ++ )
        {
          if (this.targetSel.options[j].value == this.sourceSel.options[i].value)
          {
            exsits = true;

            break;
          }
        }

        if (!exsits)
        {
          selOpt[selOpt.length] = this.sourceSel.options[i].value;
        }
      }
      else
      {
        selOpt[selOpt.length] = this.sourceSel.options[i].value;
      }
    }

    if (selOpt.length > 0)
    {
      var args = new Array();

      for (var i=2; i<arguments.length; i++)
      {
        args[args.length] = arguments[i];
      }

      Ajax.call(this.filename + "&act="+act+"&add_ids=" +selOpt.toJSONString(), args, this.addRemoveItemResponse, "GET", "JSON");
    }
  }

  /**
   * ɾ��ѡ����
   * @param   boolean    all
   * @param   string     act
   */
  this.dropItem = function(all, act)
  {
    if (!this.check())
    {
      return;
    }

    var arr = new Array();

    for (var i = this.targetSel.length - 1; i >= 0 ; i -- )
    {
      if (this.targetSel.options[i].selected || all)
      {
        arr[arr.length] = this.targetSel.options[i].value;
      }
    }

    if (arr.length > 0)
    {
      var args = new Array();

      for (var i=2; i<arguments.length; i++)
      {
        args[args.length] = arguments[i];
      }

      Ajax.call(this.filename + "&act="+act+"&drop_ids=" + arr.toJSONString(), args, this.addRemoveItemResponse, 'GET', 'JSON');
    }
  }

  /**
   * ���������صĺ���
   */
  this.addRemoveItemResponse = function(result,txt)
  {
    if (!result.error)
    {
      _self.createOptions(_self.targetSel, result.content);
    }

    if (result.message.length > 0)
    {
      alert(result.message);
    }
  }

  /**
   * ΪselectԪ�ش���options
   */
  this.createOptions = function(obj, arr)
  {
    obj.length = 0;

    for (var i=0; i < arr.length; i++)
    {
      var opt   = document.createElement("OPTION");
      opt.value = arr[i].value;
      opt.text  = arr[i].text;
      opt.id    = arr[i].data;

      obj.options.add(opt);
    }
  }
}

/* $Id : region.js 4865 2007-01-31 14:04:10Z paulgao $ */

var region = new Object();

region.isAdmin = false;

region.loadRegions = function(parent, type, target)
{
  Ajax.call(region.getFileName(), 'type=' + type + '&target=' + target + "&parent=" + parent , region.response, "GET", "JSON");
}

/* *
 * ����ָ���Ĺ��������е�ʡ��
 *
 * @country integer     ���ҵı��
 * @selName string      �б�������
 */
region.loadProvinces = function(country, selName)
{
  var objName = (typeof selName == "undefined") ? "selProvinces" : selName;

  region.loadRegions(country, 1, objName);
}

/* *
 * ����ָ����ʡ�������еĳ���
 *
 * @province    integer ʡ�ݵı��
 * @selName     string  �б�������
 */
region.loadCities = function(province, selName)
{
  var objName = (typeof selName == "undefined") ? "selCities" : selName;

  region.loadRegions(province, 2, objName);
}

/* *
 * ����ָ���ĳ����µ��� / ��
 *
 * @city    integer     ���еı��
 * @selName string      �б�������
 */
region.loadDistricts = function(city, selName)
{
  var objName = (typeof selName == "undefined") ? "selDistricts" : selName;

  region.loadRegions(city, 3, objName);
}

/* *
 * ���������б�ı�ĺ���
 *
 * @obj     object  �����б�
 * @type    integer ����
 * @selName string  Ŀ���б�������
 */
region.changed = function(obj, type, selName)
{
  var parent = obj.options[obj.selectedIndex].value;

  region.loadRegions(parent, type, selName);
}

region.response = function(result, text_result)
{
  var sel = document.getElementById(result.target);

  sel.length = 1;
  sel.selectedIndex = 0;
  sel.style.display = (result.regions.length == 0 && ! region.isAdmin && result.type + 0 == 3) ? "none" : '';

  if (document.all)
  {
    sel.fireEvent("onchange");
  }
  else
  {
    var evt = document.createEvent("HTMLEvents");
    evt.initEvent('change', true, true);
    sel.dispatchEvent(evt);
  }

  if (result.regions)
  {
    for (i = 0; i < result.regions.length; i ++ )
    {
      var opt = document.createElement("OPTION");
      opt.value = result.regions[i].region_id;
      opt.text  = result.regions[i].region_name;

      sel.options.add(opt);
    }
  }
}

region.getFileName = function()
{
  if (region.isAdmin)
  {
    return "../region.php";
  }
  else
  {
    return "region.php";
  }
}

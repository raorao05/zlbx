/*
Flash Name: Default
Description: The default flash cycle.
*/
// 0xffffff:������ɫ|1:����λ��|0x0066ff:���ֱ�����ɫ|60:���ֱ���͸����|0xffffff:����������ɫ|0x0066ff:����Ĭ����ɫ|0x000033:������ǰ��ɫ|8:�Զ�����ʱ��(��)|2:ͼƬ����Ч��|1:�Ƿ���ʾ��ť|_blank:�򿪴���
  var swf_config = "|2|||0xFFFFFF|0xFF6600||4|3|1|_blank"

  document.write('<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="'+ swf_width +'" height="'+ swf_height +'">');
  document.write('<param name="movie" value="data/flashdata/default/bcastr.swf?bcastr_xml_url=data/flashdata/default/data.xml"><param name="quality" value="high">');
  document.write('<param name="menu" value="false"><param name=wmode value="opaque">');
  document.write('<param name="FlashVars" value="bcastr_config='+swf_config+'">');
  document.write('<embed src="data/flashdata/default/bcastr.swf?bcastr_xml_url=data/flashdata/default/data.xml" wmode="opaque" FlashVars="bcastr_config='+swf_config+'" menu="false" quality="high" width="'+ swf_width +'" height="'+ swf_height +'" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="transparent"/>');
  document.write('</object>');
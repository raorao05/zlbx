<?php
/**
 * ����ע�᷵����֤
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liuhui $
 * $Id: receive.php 16492 2009-07-27 10:16:09Z liuhui $
*/

//�̻���Կ
$key="65ZS4C5WYKKLLGJN";

//�ӿڰ汾�����ɿ�
//�̶�ֵ��150120
$version=$_GET['version'];

//ǩ�����ͣ����ɿ�
//�̶�ֵ��1��1����MD5����
$signType=$_GET['signType'];

//�̻��ڿ�Ǯ�Ļ�Ա��ţ����ɿ�
$merchantMbrCode=$_GET['merchantMbrCode'];

//�����ţ����ɿ�
//ֻ��������ĸ�����֡���_���ȣ�����ĸ�����ֿ�ͷ
$requestId=$_GET['requestId'];

//�û����̻�ϵͳ��ID�����ɿ�
//ֻ��������ĸ�����֡���_���ȣ�����ĸ�����ֿ�ͷ
$userId=$_GET['userId'];

//�û���EMAIL
$userEmail=$_GET['userEmail'];

//�û�������
//���Ļ�Ӣ��
$userName=$_GET['userName'];

//��λ����
//���Ļ�Ӣ��
$orgName=$_GET['orgName'];

//��չ����һ
//���Ļ�Ӣ��
$ext1=$_GET['ext1'];

//��չ������
//���Ļ�Ӣ��
$ext2=$_GET['ext2'];

//ע����֤���
//�̶�ֵ��0��1��2
//0��ע������ɹ���1�����ͨ����2������ɹ�
$applyResult=$_GET['applyResult'];

//�������
//ʧ��ʱ���صĴ�����룬����Ϊ��
$errorCode=$_GET['errorCode'];

//��Ǯ���ص�ǩ���ַ���
//���Ϲؼ��ֵ�ֵ����Կ��ϣ���MD5�������ɵ�32λ�ַ���
$signMsg=$_GET['signMsg'];

//���ܺ�����������ֵ��Ϊ�յĲ�������ַ���
Function appendParam($returnStr,$paramId,$paramValue){
    if($returnStr!=""){
        if($paramValue!=""){
            $returnStr.="&".$paramId."=".$paramValue;
        }
    }else{
        If($paramValue!=""){
            $returnStr=$paramId."=".$paramValue;
        }
    }
    return $returnStr;
}
//���ܺ�����������ֵ��Ϊ�յĲ�������ַ���������

//�Լ����ɼ���ǩ����
///����ذ�������˳��͹�����ɼ��ܴ���
$$signMsgVal="";
$signMsgVal=appendParam($signMsgVal,"version",$version);
$signMsgVal=appendParam($signMsgVal,"signType",$signType);
$signMsgVal=appendParam($signMsgVal,"merchantMbrCode",$merchantMbrCode);
$signMsgVal=appendParam($signMsgVal,"requestId",$requestId);
$signMsgVal=appendParam($signMsgVal,"userId",$userId);
$signMsgVal=appendParam($signMsgVal,"userEmail",$userEmail);
$signMsgVal=appendParam($signMsgVal,"userName",urlencode($userName));
$signMsgVal=appendParam($signMsgVal,"orgName",urlencode($orgName));
$signMsgVal=appendParam($signMsgVal,"ext1",urlencode($ext1));
$signMsgVal=appendParam($signMsgVal,"ext2",urlencode($ext2));
$signMsgVal=appendParam($signMsgVal,"applyResult",$applyResult);
$signMsgVal=appendParam($signMsgVal,"errorCode",$errorCode);
$signMsgVal=appendParam($signMsgVal,"key",$key);

$mysignMsg=strtoupper(md5($signMsgVal));



if($mysignMsg==$signMsg){

            /**
             *  �̻������Լ������ݿ��߼���������ѽ��յ���Ϣ���浽�Լ������ݿ���
             *  �����Ǹ����Լ����ݿ����û����״̬
             */

    $status="1";

    $signMsgVal="";
    $signMsgVal=appendParam($signMsgVal,"version",$version);
    $signMsgVal=appendParam($signMsgVal,"signType",$signType);
    $signMsgVal=appendParam($signMsgVal,"merchantMbrCode",$merchantMbrCode);
    $signMsgVal=appendParam($signMsgVal,"requestId",$requestId);
    $signMsgVal=appendParam($signMsgVal,"userId",$userId);
    $signMsgVal=appendParam($signMsgVal,"status",$status);
    $reParam=$signMsgVal;
    $signMsgVal=appendParam($signMsgVal,"key",key);

    $signMsg=strtoupper(md5($signMsgVal));
    $reParam .="&signMsg=".$signMsg;
    echo $reParam; 
}else{
    echo "��֤����";
}
?>
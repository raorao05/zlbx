<?php

/**
 * ECSHOP ctopay �����ļ�
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: cncard.php 17217 2011-01-19 06:29:08Z liubo $
 */

global $_LANG;
$_LANG['cncard']          = '����֧��';
$_LANG['cncard_desc']     = '��Ϊ����B2C����������վ�����硢��רҵ����߹�ģ�Ĺ�˾֮һ������Ŀǰӵ�й��ڼ������Ƶ����п�����ʵʱ֧��ƽ̨��5���������Ʒ����������Ӫ���顣' ;

$_LANG['c_mid'] = '�̻����';
$_LANG['c_pass'] = '֧����Կ';
$_LANG['c_memo1'] = '�̻��Զ������';
$_LANG['c_moneytype'] = '֧������';
$_LANG['c_language'] = '��������';
$_LANG['c_paygate'] = '֧����ʽ';
$_LANG['cncard_button'] = '����֧��';


$_LANG['c_moneytype_range'][0] = '�����';
$_LANG['c_language_range'][0] = '����';
$_LANG['c_language_range'][1] = 'Ӣ��';
$_LANG['c_paygate_range'][0] = '����֧��';
$_LANG['c_paygate_range'][1] = '�й���������';
$_LANG['c_paygate_range'][3] = '�й�����������������';
$_LANG['c_paygate_range'][31] = '�й����������ֻ�����(����)';
$_LANG['c_paygate_range'][2000] = '�й�����ǩԼ�ͻ�(ȫ��)';
$_LANG['c_paygate_range'][2]='������������';
$_LANG['c_paygate_range'][2021]='�Ϻ���������';
$_LANG['c_paygate_range'][2022]='���������';
$_LANG['c_paygate_range'][2023]='���콨������';
$_LANG['c_paygate_range'][2024]='������������';
$_LANG['c_paygate_range'][2025]='���ս�������';
$_LANG['c_paygate_range'][2027]='������������';
$_LANG['c_paygate_range'][2028]='�Ĵ���������';
$_LANG['c_paygate_range'][2029]='������������';
$_LANG['c_paygate_range'][20371]='���Ͻ�������(ֻ��ǩԼ�û�)';
$_LANG['c_paygate_range'][20411]='������������';
$_LANG['c_paygate_range'][20431]='���ֽ�������';
$_LANG['c_paygate_range'][20451]='��������������';
$_LANG['c_paygate_range'][20512]='���ݽ�������';
$_LANG['c_paygate_range'][20532]='�ൺ��������';
$_LANG['c_paygate_range'][20571]='�㽭��������';
$_LANG['c_paygate_range'][20574]='������������(ֻ��ǩԼ�û�)';
$_LANG['c_paygate_range'][20591]='������������(ֻ��ǩԼ�û�)';
$_LANG['c_paygate_range'][20592]='���Ž�������';
$_LANG['c_paygate_range'][20731]='���Ͻ�������(ֻ��ǩԼ�û�)';
$_LANG['c_paygate_range'][20755]='���ڽ�������';
$_LANG['c_paygate_range'][20771]='������������';
$_LANG['c_paygate_range'][20791]='������������';
$_LANG['c_paygate_range'][20991]='�½���������';
$_LANG['c_paygate_range'][20314]='�ӱ���������(ֻ��ǩԼ�û�)';
$_LANG['c_paygate_range'][20351]='ɽ����������(ֻ��ǩԼ�û�)';
$_LANG['c_paygate_range'][20471]='���ɹŽ�������(ֻ��ǩԼ�û�)';
$_LANG['c_paygate_range'][20851]='���ݽ�������(ֻ��ǩԼ�û�)';
$_LANG['c_paygate_range'][20871]='���Ͻ�������(ֻ��ǩԼ�û�)';
$_LANG['c_paygate_range'][20898]='���Ͻ�������(ֻ��ǩԼ�û�)';
$_LANG['c_paygate_range'][20931]='���ཨ������(ֻ��ǩԼ�û�)';
$_LANG['c_paygate_range'][20951]='���Ľ�������(ֻ��ǩԼ�û�)';
$_LANG['c_paygate_range'][20531]='ɽ����������';
$_LANG['c_paygate_range'][86]='�й�ũҵ����';
$_LANG['c_paygate_range'][901]='�й���������(��ͨ�û�)';
$_LANG['c_paygate_range'][902]='�й���������(ǩԼ�û�)';
$_LANG['c_paygate_range'][5]='�й��������';
$_LANG['c_paygate_range'][5]='�㶫��չ����';
$_LANG['c_paygate_range'][5]='����ʵҵ����';
$_LANG['c_paygate_range'][94]='���ڷ�չ����';
$_LANG['c_paygate_range'][42]='������ҵ����';
$_LANG['c_paygate_range'][47]='�й���ͨ����';
$_LANG['c_paygate_range'][87]='���ʿ�';
$_LANG['c_paygate_range'][100]='������Ա����';
$_LANG['c_paygate_range'][5]='�㶫�������ϰ�ȫ֧��ƽ̨';
$_LANG['c_paygate_range'][5]='�㶫������������';
$_LANG['c_paygate_range'][7]='���Ž�����֧������';
$_LANG['c_paygate_range'][5]='�й�����(�㶫�����ڳ���)';
$_LANG['c_paygate_range'][7]='�й�����(���Ž�ǿ�)';
$_LANG['c_paygate_range'][5]='��������(�㶫)';
$_LANG['c_paygate_range'][5]='������ҵ����(����)';
$_LANG['c_paygate_range'][5]='��������ҵ����(����)';
$_LANG['c_paygate_range'][5]='����ũ�����ú�����(����)';
$_LANG['c_paygate_range'][5]='�Ϻ��ֶ���չ����(����)';
$_LANG['account_voucher']   = '��Ա�ʻ���ֵ';
$_LANG['shop_order_sn']     = '�̳Ƕ�����';

?>
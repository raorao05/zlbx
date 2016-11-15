<?php
class imgupload{
    public $previewsize=0.125  ;   //Ԥ��ͼƬ����
    public $preview=0;   //�Ƿ�����Ԥ������Ϊ1����Ϊ0
    public $datetime;   //�����
    public $ph_name;   //�ϴ�ͼƬ�ļ���
    public $ph_tmp_name;    //ͼƬ��ʱ�ļ���
    public $ph_path="./upload/";    //�ϴ��ļ����·��
    public $ph_type;   //ͼƬ����
    public $ph_size;   //ͼƬ��С
    public $imgsize;   //�ϴ�ͼƬ�ߴ磬�����ж���ʾ����
    public $al_ph_type=array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-excel');//07�汾    //�����ϴ�ͼƬ����//'application/vnd.ms-excel', 07֮ǰ�İ汾
    public $al_ph_size=1000000;   //�����ϴ��ļ���С
    function __construct(){
        $this->set_datatime();
    }
    function set_datatime(){
        $this->datetime=date("YmdHis");
    }
    //��ȡ�ļ�����
    function get_ph_type($phtype){
        $this->ph_type=$phtype;
    }
    //��ȡ�ļ���С
    function get_ph_size($phsize){
        $this->ph_size=$phsize."<br>";
    }
    //��ȡ�ϴ���ʱ�ļ���
    function get_ph_tmpname($tmp_name){
        $this->ph_tmp_name=$tmp_name;
        $this->imgsize=getimagesize($tmp_name);
    }
    //��ȡԭ�ļ���
    function get_ph_name($phname){
        $this->ph_name=$this->ph_path.$this->datetime.strrchr($phname,"."); //strrchr��ȡ�ļ��ĵ����һ�γ��ֵ�λ��
        //$this->ph_name=$this->datetime.strrchr($phname,"."); //strrchr��ȡ�ļ��ĵ����һ�γ��ֵ�λ��
        return $this->ph_name;
    }
    // �ж��ϴ��ļ����Ŀ¼
    function check_path(){
        if(!file_exists($this->ph_path)){
            mkdir($this->ph_path);
        }
    }
    //�ж��ϴ��ļ��Ƿ񳬹������С
    function check_size(){
        if($this->ph_size>$this->al_ph_size){
            $this->showerror("�ϴ��ļ�����2000KB");
        }
    }
    //�ж��ļ�����
    function check_type(){
        if(!in_array($this->ph_type,$this->al_ph_type)){
            echo $this->ph_type;
            $this->showerror("�ϴ��ļ����ʹ���".$this->ph_type);
        }
    }
    //�ϴ�ͼƬ
    function up_photo(){

        if(!move_uploaded_file($this->ph_tmp_name,$this->ph_name)){
            $this->showerror("�ϴ��ļ�����");
        }
    }
    //ͼƬԤ��
    function showphoto(){
        if($this->preview==1){
            if($this->imgsize[0]>2000){
                $this->imgsize[0]=$this->imgsize[0]*$this->previewsize;
                $this->imgsize[1]=$this->imgsize[1]*$this->previewsize;
            }
            echo("<img src=\"{$this->ph_name}\" width=\"{$this->imgsize['0']}\" height=\"{$this->imgsize['1']}\">");
        }
    }
    //������ʾ
    function showerror($errorstr){
        echo "<script language=javascript>alert('$errorstr');location='javascript:history.go(-1)';</script>";
        exit();
    }
    function save(){
        $this->check_path();
        $this->check_size();
        //$this->check_type();
        $this->up_photo();
        $this->showphoto();
    }
}
?>
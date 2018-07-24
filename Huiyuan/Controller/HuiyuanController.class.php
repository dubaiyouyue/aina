<?php

namespace Addons\Huiyuan\Controller;
use Home\Controller\AddonsController;

class HuiyuanController extends AddonsController{
	var $model;
	function _initialize() {
		$this->model = $this->getModel ( 'huiyuan' );
		parent::_initialize ();
		$act = strtolower ( _ACTION );
		$type = I ( 'type' );
		
		$res ['title'] = '会员列表';
		$res ['url'] = addons_url ( 'Huiyuan://Huiyuan/lists' );
		$res ['class'] = $act == 'lists' || $type == 'text' ? 'current' : '';
		$nav [] = $res;
		
		$res ['title'] = '文本注册';
		$res ['url'] = addons_url ( 'Huiyuan://Huiyuan/dr' );
		$res ['class'] = $act == 'dr' || $type == 'textarea' ? 'current' : '';
		$nav [] = $res;

		$res ['title'] = '批量导入会员注册';
		$res ['url'] = addons_url ( 'Huiyuan://Huiyuan/daoru' );
		$res ['class'] = $act == 'daoru' || $type == 'textarea' ? 'current' : '';
		$nav [] = $res;
		
		
		$this->assign ( 'nav', $nav );
	}
	//随机盐
	function generate_rand($l){
	  $c= "ABCDEFGHJKLMNPQRSTUVWXYabcdefghijkmnpqrstuvwxy3456789";
	  srand((double)microtime()*1000000);
	  for($i=0; $i<$l; $i++) {
		  $rand.= $c[rand()%strlen($c)];
	  }
	  return $rand;
	}
	function ree($tel,$pass,$yue){
		
		
		if(!$tel) return false;

		
				$mapc['tel']=$tel;
				$s_tel=M('huiyuan')->where($mapc)->limit(0,1)->select();
				$s_tel=($s_tel['0']['id']);
				if($s_tel) return false;
		
			//写入注册信息
			$data ['token'] = get_token ();
			//$data['rip']=$this->getip();
			$data['tel']=($tel+0);//$_SESSION['check_mobile'];//$_POST['tel'];
			$salt=$this->generate_rand(9);//rand(100000,999999);
			$data['salt']=$salt;
			$data['pass']=md5($pass.$salt);
			$data['cTime']=time();
			$data['mTime']=$data['cTime'];
			$saltr=$this->generate_rand(9);
			$data['saltr']=$saltr;
			//$data['lip']=$data['rip'];
			$data['zcj']=0;//$_SESSION['guanzhu_choujiang'];
			//$data['logg']=md5($data['rip'].$data['saltr']);//md5($data['rip'].$data['mTime'].$data['saltr']);
				//注册送抽奖次数
				//$nnpn=($this->config);
				//$nnpn=$nnpn['cjzss']+0;
				
				//$nnpncjzssdd=($this->config);
				//$nnpncjzssdd=$nnpncjzssdd['cjzssdd']+0;
				
				//$data['dtime']=date('Ymd');
				
				//if($nnpn) $data['zcj']=$_SESSION['guanzhu_choujiang']+$nnpn;//$_SESSION['guanzhu_choujiang']+$nnpn;
			
			$res = M('Huiyuan')->add($data);
			if($res){
				
						$dataa['uid']=$res;
						$dataa['tel']=$data['tel'];
						$dataa['yue']=($yue+0);
						$dataa['mtime']=time();
						$aaasss=M('recharge')->add($dataa);
				
				
				//echo '成功注册 '.$tel.'<br />';
			}
			return $aaasss;
		
	}
	function daoru(){
		if (! is_login ()) {
			redirect ( U ( 'home/user/login', array (
					'from' => 2 
			) ) );
		}
		/*if($_POST){
			$this->daorudata();
			exit;
		}*/
		//dump($_POST);
		$this->display ();
	}
	function daorudata(){
		$new_text='请上传Excel文件';
		
		if(! empty ( $_FILES ['file_stu'] ['name'] )){
			
				$file = $_FILES ['file_stu'] ['tmp_name'];
				$file_types = explode ( ".", $_FILES ['file_stu'] ['name'] );
				$file_type = $file_types [count ( $file_types ) - 1];
				 /*判别是不是.xls文件，判别是不是excel文件*/
				 if (strtolower ( $file_type ) != "xls"){
					  $new_text='不是Excel文件，重新上传';
					  //exit;
				 }
				 else{
			// 判断文件是什么格式
    $type = pathinfo($file); 
    $type = strtolower($type["extension"]);
    $type=$type==='csv' ? $type : 'Excel5';
    ini_set('max_execution_time', '0');
    Vendor('PHPExcelN.PHPExcel');
    // 判断使用哪种格式
    $objReader = \PHPExcel_IOFactory::createReader($type);
    $objPHPExcel = $objReader->load($file); 
    $sheet = $objPHPExcel->getSheet(0); 
    // 取得总行数 
    $highestRow = $sheet->getHighestRow();     
    // 取得总列数      
    $highestColumn = $sheet->getHighestColumn(); 
    //循环读取excel文件,读取一条,插入一条
    $data=array();
    //从第一行开始读取数据
	//dump($data);
    for($j=2;$j<=$highestRow;$j++){
        //从A列读取数据
		
        for($k='A';$k<='B';$k++){
            
			
			
			// 读取单元格
			//$k='A';
            if($objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue()){
				$vsfsd=$objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
				//电话
				if($k=='A'){
					$tel=$vsfsd;
				}
				if($k=='B'){
					$yue=$vsfsd;
				}
				$newdr=$tel.'#'.$yue;
				/*$data[$j][]=$objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
				
				if($k=='A') $newdr[$k]['tel']=$vsfsd;
				$pass=str_split('0'.$vsfsd,6);
				if($k=='A') $newdr[$k]['pass']=$pass['1'];
				$daoruok=$this->ree($newdr[$k]['tel'],$newdr[$k]['pass']);*/
				//成功注册
				/*if($daoruok){
					$daoruokstr.='成功注册'.$newdr[$k]['tel'].'<br>';
				}else{
					$daoross.='导入失败'.$newdr[$k]['tel'].'<br>';
				}*/
				/*$daoross.=$newdr[$k]['tel'].'<br>';
				if($j==$highestRow) $daoross.='会员数据导入结束。<br>';*/
				//$this->display ();
				
			}
			
        } 		
				$newdr=explode('#',$newdr);
				$pass=str_split('0'.$newdr['0'],6);
				$pass=$pass['1'];
				$daoruok=$this->ree($newdr['0'],$pass,$newdr['1']);
				//成功注册
				if($daoruok){
					$daoruokstrsss='<span style="color:blue;">成功注册</span>';
				}else{
					$daoruokstrsss='<span style="color:red;">导入失败/手机已注册</span>';
				}
				$daoross.='<p style="color:#000;">第'.($j-1).'条 电话 '.$newdr['0'].' 余额 '.$newdr['1'].' '.$daoruokstrsss.'</p>';
				if($j==$highestRow) $daoross.='<br><p style="color:blue;">会员数据导入结束。</p>';
				//$this->display ();
    }  
	//dump($data);
	$new_text='<p style="color:blue;">正在导入中...</p>';

    //return $data;
	}
 
		}
	$this->assign ( 'daoruokstr', $daoruokstr );
	$this->assign ( 'daoross', $daoross );
		$this->assign ( 'new_text', $new_text );
		$this->display ();
	}
	
	function dr(){
		if (! is_login ()) {
			redirect ( U ( 'home/user/login', array (
					'from' => 2 
			) ) );
		}
		
		//echo get_token ();exit;
		//$templateFile = $this->model ['template_list'] ? $this->model ['template_list'] : '';
		//$this->display ( $templateFile );
		$dr=I ( 'dr' );
		if($dr) {
			//$this->error ( $Model->getError () );
			//dump(I ( 'dr' ));
			//$dr=str_ireplace("\r\n",'#',$dr);
			//$nnpnxxee=str_ireplace("购",'',$nnpnxxee);
			$dr=explode("\r\n",$dr);
			foreach ($dr as $k=>&$vsfsd) {
				$vsfsd = str_ireplace(' ','',$vsfsd);
				$vsfsd=explode('#',$vsfsd);
				$newdr[$k]['tel']=$vsfsd['0'];
				$pass=str_split('0'.$vsfsd['0'],6);
				$newdr[$k]['pass']=$pass['1'];
				$this->ree($newdr[$k]['tel'],$newdr[$k]['pass'],$vsfsd['1']);
			}
			//dump($newdr);
			
			$url = U ( 'lists' );
			$this->success ( '批量注册完成！', $url,3 );
			exit;
		}
		else $this->display ();
	}
	
	
	public function del() {

	}	public function add() {
			$this->del();
			return false;
	}
	
}

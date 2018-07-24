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
		
		$res ['title'] = '批量注册';
		$res ['url'] = addons_url ( 'Huiyuan://Huiyuan/dr' );
		$res ['class'] = $act == 'dr' || $type == 'textarea' ? 'current' : '';
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
	function ree($tel,$pass){
		
		
		

		
				$mapc['tel']=$tel;
				$s_tel=M('huiyuan')->where($mapc)->limit(0,1)->select();
				$s_tel=($s_tel['0']['id']);
				if($s_tel) return false;
		
			//写入注册信息
			$data ['token'] = get_token ();
			//$data['rip']=$this->getip();
			$data['tel']=$tel;//$_SESSION['check_mobile'];//$_POST['tel'];
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
				echo '成功注册 '.$tel.'<br />';
			}
		
	}
	function dr(){
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
				$newdr[$k]['tel']=$vsfsd;
				$pass=str_split('0'.$vsfsd,6);
				$newdr[$k]['pass']=$pass['1'];
				$this->ree($newdr[$k]['tel'],$newdr[$k]['pass']);
			}
			//dump($newdr);
			
			$url = U ( 'lists' );
			$this->success ( '批量注册完成！', $url,9 );
			exit;
		}
		else $this->display ();
	}
}

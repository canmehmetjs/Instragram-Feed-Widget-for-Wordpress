<?php 
/*
Plugin Name: Instagram Feed
Plugin URI: www.tomplabs.com
Description: A simple and fast Instagram plugin. 
Version: 1.0
Author: Can Mehmet
Author URI: http://tomplabs.com/can
*/


// Get it from here : https://elfsight.com/service/generate-instagram-access-token/
$access_token = '';

// Get client id and secret from here https://www.instagram.com/developer/
$client_id = '';
$client_secret = '';
$username = '';
// Get user id from here : https://smashballoon.com/instagram-feed/find-instagram-user-id/
$user_id = '';
		



if ( !function_exists('bonuin_instagram_get_user_info')) {
	function bonuin_instagram_get_user_info($data_requested){
		
		
		global $access_token,$client_id,$client_secret,$username,$user_id;
	
		$user_search = "https://api.instagram.com/v1/users/" . $user_id . "/?access_token=".  $access_token;
		$response = wp_remote_get( esc_url_raw( $user_search ) );
		$api_response = json_decode( wp_remote_retrieve_body( $response ), true );
		
		$temp = '';
		
		switch($data_requested){
			case 'user_name':
				$temp = $api_response['data']['username'];
			break;
			case 'user_image':
				$temp = $api_response['data']['profile_picture'];
			break;
			case 'user_bio':
				$temp = $api_response['data']['bio'];
			break;
			case 'user_website':
				$temp = $api_response['data']['website'];
			break;
			case 'user_full_name':
				$temp = $api_response['data']['full_name'];
			break;
			case 'followers':
				$temp = $api_response['data']['counts']['followed_by'];
			break;
			case 'following':
				$temp = $api_response['data']['counts']['follows'];
			break;
			
		}
		
		
		return $temp;
		//echo '<pre>' . var_export($api_response, true) . '</pre>';
	}
}


if ( !function_exists('bonuin_instagram_get_user_media')) {
	function bonuin_instagram_get_user_media($type){
		
		global $access_token,$client_id,$client_secret,$username,$user_id;
		
		$column = '';
		$height = '';
		$li_width = '';
		
		$user_search = "https://api.instagram.com/v1/users/self/media/recent/?access_token=". $access_token;
		$response = wp_remote_get( esc_url_raw( $user_search ) );
		$api_response = json_decode( wp_remote_retrieve_body( $response ), true );
		
		?>
		<?php if ($type == 'widget'){
			$column = '110px';
			$height = '110px';
			$li_width = '32%';
			$counter_limit = '6';
		}else{
			$column = '19.5%';
			$height = '300px';
			$li_width = '19.5%;';
			$counter_limit = '10';
		}
		?>
		<div class="table">
			<ul class="list-inline instagram_images">
				<?php 
				$counter = '1';
				foreach ($api_response['data'] as $item ){
					$counter++;
					$image_link 			= $item['link'];
					$image_likes 			= $item['likes']['count'];
					$image_low_resolution 	= $item['images']['low_resolution']['url'];
					$image_low_resolution_w = $item['images']['low_resolution']['width'];
					$image_low_resolution_h = $item['images']['low_resolution']['height'];
					$image_thumbnail	 	= $item['images']['thumbnail']['url'];
					$image_caption 			= $item['caption']['text'];
					
					?>
					<li style="width:<?php echo $li_width;?>">
						<a href="<?php echo $image_thumbnail;?>" target="_blank" title="<?php echo $image_caption;?>" style="height:109px">
							<div class="instagram_image_item">
								<img src="<?php echo $image_low_resolution;?>" style="width:<?php echo $column;?>;height:<?php echo $height;?>">
							</div>
						</a>
					</li>
					<?php 
					
					
					if ($counter > $counter_limit){
						break;
					}
				}
				?>
			
			</ul>
		</div>
		
		<?php 
		
	}
}
	 
	 
	
   
?>
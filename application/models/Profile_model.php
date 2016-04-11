<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Profile_model extends CI_Model {

        private $data;

        public function __construct()
        {
                parent::__construct();
        }
        
        public function update_rating($value)
        {
            $this->db->query("UPDATE `profile` SET `rating`= `rating` + ".$value." WHERE `user_id`='".$this->session->userdata('user_info')->user_id."'");
        }

        public function update_contacts_item($param_name,$param_value)
        {
            $pre_value = $this->session->userdata('user_info')->$param_name;
            
            if($param_value == '')
            {
                if($pre_value != $param_value)
                {
                    $this->update_rating( -1 * MainSiteConfig::get_rating_value($param_name));
                    $this->db->update('profile',array(
                        $param_name => $param_value
                    ),array(
                        'user_id'=>  $this->session->userdata('user_info')->user_id
                    ));
                }
            }
            elseif($param_value !='' && $pre_value !='')
            {
                $this->db->update('profile',array(
                    $param_name => $param_value
                ),array(
                    'user_id'=>  $this->session->userdata('user_info')->user_id
                ));
            }
            else
            {
                $this->update_rating( MainSiteConfig::get_rating_value($param_name));
                $this->db->update('profile',array(
                    $param_name => $param_value
                ),array(
                    'user_id'=>  $this->session->userdata('user_info')->user_id
                ));
            }
        }

        public function update_avatar($file_name,$source_dir,$dest_dir)
        {
            if(file_exists($source_dir.'260_'.$file_name) && file_exists($source_dir.'30_'.$file_name))
            {
                copy($source_dir.'260_'.$file_name, '.'.$dest_dir.'big_'.$file_name);
                copy($source_dir.'30_'.$file_name, '.'.$dest_dir.'small_'.$file_name);
                
                if(file_exists('.'.$dest_dir.'big_'.$file_name) && file_exists('.'.$dest_dir.'small_'.$file_name))
                {
                    unlink($source_dir.'260_'.$file_name);
                    unlink($source_dir.'30_'.$file_name);
                    
                    
                    $res = $this->db->get_where('profile',array(
                        'user_id'=>$this->session->userdata('user_info')->user_id
                    ))->row();
                    if($res->big_photo || $res->small_photo)
                    {
                        unlink('.'.$res->big_photo);
                        unlink('.'.$res->small_photo);
                        $this->db->update('profile',array(
                            'big_photo'   => $dest_dir.'big_'.$file_name,
                            'small_photo' => $dest_dir.'small_'.$file_name
                        ),array(
                            'user_id'=>$this->session->userdata('user_info')->user_id
                        ));
                        return true;
                    }
                    else
                    {
                        $this->db->update('profile',array(
                            'big_photo'   => $dest_dir.'big_'.$file_name,
                            'small_photo' => $dest_dir.'small_'.$file_name
                        ),array(
                            'user_id'=>$this->session->userdata('user_info')->user_id
                        ));
                        $this->update_rating(MainSiteConfig::get_rating_value('avatar'));
                        return true;
                    }
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
            
        }
        
        
        
        public function update_type_cost($param_name, $param_value)
        {
            $pp = $param_name == 'per_project' ? 1 : '';
            $ph = $param_name == 'per_hour'    ? 1 : '';
            $this->db->update('profile',array(
                'per_project'   => $pp,
                'per_hour' => $ph
            ),array(
                'user_id'=>$this->session->userdata('user_info')->user_id
            ));
        }
        
        
        
        public function get_photo_in_albums_count($user_id)
        {
            $res = $this->db->query('SELECT count(id) as `photo_cnt`,`album_id` FROM `users_photo` WHERE `user_id` ="'.$user_id.'" AND `album_id` IN (SELECT id FROM ganres WHERE user_type = "'.$this->session->userdata('user_info')->account_type.'" ) GROUP BY `album_id`')->result();
            $tmp_res=  array();
            foreach($res as $one)
            {
                $tmp_res[$one->album_id] = $one->photo_cnt;
            }
            return $tmp_res;
        }
        
        public function get_photo_in_personal_albums_count($user_id)
        {
            $res = $this->db->query('SELECT count(id) as `photo_cnt`,`album_id` FROM `users_photo` WHERE `user_id` ="'.$user_id.'" AND `album_id` IN (SELECT id FROM personal_album WHERE user_id = "'.$user_id.'" ) GROUP BY `album_id`')->result();
            $tmp_res=  array();
            foreach($res as $one)
            {
                $tmp_res[$one->album_id] = $one->photo_cnt;
            }
            return $tmp_res;
        }
        
        
        public function get_personal_album($user_id)
        {
            $res = $this->db->get_where('personal_album',array('user_id'=>$user_id))->result();
            return $res;
        }
        
        
        public function get_personal_album_id_by_array($user_id)
        {
            $res = $this->db->get_where('personal_album',array('user_id'=>$user_id))->result();
            $tmp_res = array();
            foreach($res as $one)
            {
                $tmp_res[$one->id] = $one;
            }
            return $tmp_res;
        }
        
        public function get_personal_album_by_id($album_id)
        {
            $res = $this->db->get_where('personal_album',array('id'=>$album_id))->result();
            return $res;
        }
        
        
        
        public function get_personal_album_count($user_id)
        {
            $res = $this->db->get_where('personal_album',array('user_id'=>$user_id))->num_rows();
            return $res;
        }
 
        public function create_personal_album($album_name)
        {
            $this->db->insert('personal_album',array(
                'id'      => '',
                'user_id' => $this->session->userdata('user_info')->user_id,
                'name'    => $album_name
            ));
        }
        
        
        
        public function get_albums_photo($album_id)
        {
           $res = $this->db->limit($this->session->userdata('user_info')->profi ? MainSiteConfig::get_profi_parametrs('profi_photo_count') : MainSiteConfig::get_profi_parametrs('non_profi_photo_count'))->get_where('users_photo',array(
               'user_id'  => $this->session->userdata('user_info')->user_id,
               'album_id' => $album_id
               ))->result();
            return $res;
        }
        
        
        public function save_photo_to_album($filename,$album_id,$width = 0, $height = 0)
        {
            if($this->count_photo_in_album($album_id) < MainSiteConfig::get_profi_parametrs($this->session->userdata('user_info')->profi ? 'profi_photo_count' : 'non_profi_photo_count'))
            {
                $this->db->insert('users_photo',array(
                    'id'       => '',
                    'user_id'  => $this->session->userdata('user_info')->user_id,
                    'album_id' => $album_id,
                    'filename' => $filename,
                    'width'    => $width,
                    'height'   => $height
                ));
                return true;
            }
            else
            {
                return false;
            }
            
            
        }
        
        
        public function get_all_users_albums()
        {
            $personal_album = $this->get_personal_album($this->session->userdata('user_info')->user_id);
            $ganres_albums  = $this->db->get_where('ganres',array(
                'user_type' => $this->session->userdata('user_info')->account_type
            ))->result();
            
            $res_albums = array();
            if($this->session->userdata('user_info')->profi)
            {
                foreach($personal_album as $one)
                {
                    $res_albums[] = $one->id;
                }
            }
            foreach($ganres_albums as $one)
            {
                $res_albums[] = $one->id;
            }
            
            return $res_albums;
        }
        
        
        public function count_photo_in_album($album_id)
        {
            $res = $this->db->get_where('users_photo',array(
               'user_id'  => $this->session->userdata('user_info')->user_id,
               'album_id' => $album_id
               ))->num_rows();
      
            return $res;
        }
        
        
        
        public function get_file_id_by_file_name($file_name)
        {
            $res = $this->db->get_where('users_photo',array(
               'user_id'  => $this->session->userdata('user_info')->user_id,
               'filename' => $file_name
               ))->row();
            return $res->id;
        }
        
        
        public function count_photo_in_best()
        {
            $res = $this->db->get_where('best_photos',array(
               'user_id'  => $this->session->userdata('user_info')->user_id
               ))->num_rows();
      
            return $res;
        }
        
        
        public function set_in_best_photos($photo_id)
        {
            $this->db->insert('best_photos',array(
                'id'       => '',
                'user_id'  => $this->session->userdata('user_info')->user_id,
                'photo_id' => $photo_id
            ));
        }
        
        public function unset_from_best_photos($photo_id)
        {
            $this->db->delete('best_photos',array(
                'user_id'  => $this->session->userdata('user_info')->user_id,
                'photo_id' => $photo_id
            ));
        }
        
        
        public function get_user_best_photo_as_array()
        {
            $res = $this->db->select('photo_id')->get_where('best_photos',array(
               'user_id'  => $this->session->userdata('user_info')->user_id
            ))->result();
            $tmp_res = array();
            foreach($res as $one)
            {
                $tmp_res[] = $one->photo_id;
            }
            return $tmp_res;
        }
        
        
        public function get_all_users_best_photos($user_id)
        {
            $res = $this->db->query("SELECT up.id as photo_id, up.height as height, up.width as width, up.filename as filename FROM `best_photos` as bp, `users_photo` as up WHERE up.user_id = '".$user_id."' AND up.id = bp.photo_id GROUP BY up.id");
            return $res->result();
        }
        
        public function try_delete_from_best_photos($photo_id)
        {
            $this->db->delete('best_photos',array(
                'photo_id' => $photo_id,
                'user_id'  => $this->session->userdata('user_info')->user_id
            ));
        }
        
        
        public function get_users_albums_with_photo($user_id)
        {
            $this->db->query("SET sql_mode ='';");
            $res = $this->db->query("SELECT id,album_id,filename FROM users_photo WHERE user_id = '".$user_id."' GROUP BY album_id;")->result();
            $tmp_arr = array();
            $pers_albums = $this->get_personal_album_id_by_array($this->session->userdata('user_info')->user_id);
            foreach($res as $one)
            {
                if(in_array($one->album_id, $pers_albums))
                {
                    if($this->session->userdata('user_info')->profi)
                    {
                        $tmp_arr[] = $one;
                    }
                }
                else
                {
                    $tmp_arr[] = $one;
                }
            }
            return $tmp_arr;
        }
        
        public function get_all_users_photos()
        {
            $res = $this->db->get_where('users_photo',array(
                'user_id'=>$this->session->userdata('user_info')->user_id
            ))->result();
            $tmp_mas = array();
            foreach($res as $one)
            {
                $tmp_mas[$one->album_id][] = $one;
            }
            
            return $tmp_mas;
        }
        
        
        
        public function get_all_actions()
        {
            $res = $this->db->order_by('create_date','desc')->limit($this->session->userdata('user_info')->profi ? MainSiteConfig::get_profi_parametrs('profi_actions') : MainSiteConfig::get_profi_parametrs('non_profi_actions'))->get_where('actions',array(
               'user_id'  => $this->session->userdata('user_info')->user_id
               ))->result();
            return $res;
        }
        
        public function get_user_actions_count()
        {
            $res = $this->db->get_where('actions',array(
               'user_id'  => $this->session->userdata('user_info')->user_id
            ))->num_rows();
            return $res;
        }

        public function save_user_action($title,$text='',$image='',$end_date='')
        {
            if($end_date)
            {
                
            }
            else
            {
                $end_date = mktime(0, 0, 0, date("m"), date("d"),   date("Y"));
                $end_date = date("Y-m-d H:i:s",  strtotime("+1 month",$end_date)); 
            }
                
            
            $this->db->insert('actions',array(
                'id'       => '',
                'user_id'  => $this->session->userdata('user_info')->user_id,
                'create_date' => date("Y-m-d H:i:s"),
                'end_date'    => $end_date,
                'title'       => substr($title, 0, 255),
                'text'        => $text,
                'image'       => $image
            ));
            
            $this->update_rating(MainSiteConfig::get_rating_value('actions'));
        }
        
        public function get_action_info($action_id)
        {
            $res = $this->db->get_where('actions',array(
                'user_id' => $this->session->userdata('user_info')->user_id,
                'id'      => $action_id
            ))->row();
            return $res;
        }
        
        public function delete_action($action_id)
        {
            $this->db->delete('actions', array(
                'user_id' => $this->session->userdata('user_info')->user_id,
                'id'      => $action_id
            ));
        }
        
        
        public function get_all_users_comments()
        {
            $this->db->order_by('create_date','desc');
            $this->db->where('to_user_id',$this->session->userdata('user_info')->user_id);
            $this->db->join('profile','profile.user_id = comments.from_user_id');
            $res = $this->db->get('comments')->result();
            return $res;
        }
        
        
        public function get_comments_count()
        {
            $res = $this->db->query("SELECT type_comments,COUNT(id) as cnt FROM `comments` WHERE to_user_id = '".$this->session->userdata('user_info')->user_id."' GROUP BY type_comments ")->result();
            $tmp = array();
            foreach($res as $one)
            {
                $tmp[$one->type_comments] = $one->cnt ? $one->cnt : 0;
            }
            return $tmp;
        }
        
        public function check_bookmarks()
        {
            $res = $this->db->query("SELECT count(user_id) as cnt FROM `profile` WHERE bookmarks LIKE '%".$this->session->userdata('user_info')->user_id."%'")->row();
            return $res->cnt;
        }
        
        
        
        public function get_all_users_albums_by_id_key_array()
        {
            $personal_album = $this->get_personal_album($this->session->userdata('user_info')->user_id);
            $ganres_albums  = $this->db->get_where('ganres',array(
                'user_type' => $this->session->userdata('user_info')->account_type
            ))->result();
            
            $res_albums = array();
            if($this->session->userdata('user_info')->profi)
            {
                foreach($personal_album as $one)
                {
                    $res_albums[$one->id] = $one;
                }
            }
            foreach($ganres_albums as $one)
            {
                $res_albums[$one->id] = $one;
            }
            
            return $res_albums;
        }
        
        public function delete_personal_album($album_id)
        {
            $this->db->delete('personal_album',array(
                'id'      => $album_id,
                'user_id' => $this->session->userdata('user_info')->user_id
            ));
        }
        
        public function plus_balance($summ,$user_id, $id_check='')
        {
            $this->db->query("UPDATE `profile` SET `balance` = `balance` + '".$summ."' WHERE `user_id`='".$user_id."' LIMIT 1");
            $this->db->insert('payment',array(
                'id'      => '',
                'user_id' => $user_id,
                'create_date' => date("Y-m-d H:i:s"),
                'plus' => 1,
                'value' => $summ,
                'desct' => 'Пополнение баланса '.$id_check ? " по квитанции № ".$id_check: ''
            ));
        }
        
        
        public function get_history_balance($cnt_entries='',$from_id = '')
        {
            if($cnt_entries)
            {
               
                return $this->db->query("SELECT * FROM `payment` WHERE `user_id`='".$this->session->userdata('user_info')->user_id."' ".($from_id ? " AND `id` < '".$from_id ."'" : "")." ORDER BY `create_date` DESC LIMIT ".$cnt_entries)->result();
            }
            else
            {
                return $this->db->order_by('create_date','desc')->get_where('payment',array(
                    'user_id' => $this->session->userdata('user_info')->user_id
                ))->result();
            }
        }
        
}
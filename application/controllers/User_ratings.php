<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class User_ratings extends CI_Controller
{
    public $path = 'uploads/';

    public function __construct()
	{
		parent::__construct();
		$this->load->model('generalmodel');
        $this->path = $this->path.$this->config->item('property_images');
	}

    protected $table = SEND_INVITES_TABLE;

    public function index($send_invites_id, $rating_platform_id = null)
    {
        $send_invites_id = d_id($send_invites_id);

        $inviteData = $this->generalmodel->get($this->table, 'status, property_id', ['id' => $send_invites_id, 'rating_completed' => 0, 'is_delete' => 0]);
        $platformData = [];

        if($rating_platform_id && $inviteData) {
            $rating_platform_id = d_id($rating_platform_id);
            $platformData = $this->generalmodel->get(RATING_SETTINGS_TABLE, 'min_rating, rating_url, average_review', ['property_id' => $inviteData['property_id'], 'rating_platform_id' => $rating_platform_id, 'status' => 1]);
            $data['property'] = $this->generalmodel->get(PROPERTIES, 'name, short_description, long_description, images', ['id' => $inviteData['property_id'], 'is_delete' => 0]);
        }

        if($this->input->is_ajax_request()) {
            if(empty($inviteData) || empty($platformData) || empty($data['property'])) {
                responseMsg(false, 'Link Expired!', true);
            }

            $update = [
                'rating_platform_id'    => $rating_platform_id,
                'rating'                => $this->input->post('rating'),
                'comments'              => $this->input->post('comments'),
                'status'                => 'Rating given',
                'rating_completed'      => 1
            ];

            $redirect = $this->input->post('rating') > $platformData['min_rating'] ? $platformData['rating_url'] : site_url('user-ratings/thank-you');

            if ($this->generalmodel->update(['id' => $send_invites_id], $update, $this->table)) {
                $response = ['error' => false, 'message' => "We value your feedback! Thank you!", "redirect" => $redirect];
            }else{
                $response = ['error' => true, 'message' => 'Some error occurs while sending email. Try again.'];
            }

            die(json_encode($response));
        } else{
            if(empty($inviteData)) {
                return $this->link_expired();
            }
            $data['title'] = 'User ratings';
            $data['validate'] = true;
            $data['inviteData'] = $inviteData;
            $data['platformData'] = $platformData;
            
            if(!empty($platformData)) {
                $data['rating_platform'] = $this->generalmodel->get(RATING_PLATFORMS_TABLE, 'logo', ['id' => $rating_platform_id]);
                if(empty($data['property'])) {
                    return $this->link_expired();
                }
                return $this->template->load('front-end/template', 'user_ratings/user_ratings', $data);
            } else {
                $data['rating_platforms'] = $this->generalmodel->getRatingPlatforms($inviteData['property_id'], 1);
                return $this->template->load('front-end/template', 'user_ratings/home', $data);
            }
        }
    }

    public function link_expired()
    {
        $data['title'] = 'User ratings | Link Expired';
        $data['errorPage'] = true;

        return $this->template->load('front-end/template', 'user_ratings/link_expired', $data);
    }

    public function thank_you()
    {
        $data['title'] = 'User ratings | Thank you';
        $data['errorPage'] = true;

        return $this->template->load('front-end/template', 'user_ratings/thank_you', $data);
    }
}
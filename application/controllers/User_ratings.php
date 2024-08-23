<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class User_ratings extends MY_Controller
{
    protected $table = SEND_INVITES_EMAILS_TABLE;

    public function index($rating_platform_id, $send_invites_id)
    {
        $rating_platform_id = d_id($rating_platform_id);
        $send_invites_id = d_id($send_invites_id);

        $inviteData = $this->generalmodel->get($this->table, 'rating_platforms, status, send_invite_id, property_id', ['id' => $send_invites_id, 'status' => 'Email Sent', 'is_delete' => 0]);

        if($inviteData) {
            $platformData = $this->generalmodel->get(RATING_SETTINGS_TABLE, 'min_rating, rating_url', ['property_id' => $inviteData['property_id'], 'rating_platform_id' => $rating_platform_id, 'status' => 1]);
        }

        if($this->input->is_ajax_request()) {
            if(empty($inviteData) || empty($inviteData)) {
                responseMsg(false, 'Link Expired!', true);
            }

            $rating_platforms = json_decode($inviteData['rating_platforms'], TRUE);

            foreach ($rating_platforms as $k => $platform) {
                if($platform['platform_id'] === $rating_platform_id) {
                    $rating_platforms[$k]['rating'] = $this->input->post('rating');
                    $rating_platforms[$k]['comments'] = $this->input->post('comments');
                }
            }

            $update = [
                'rating_platforms'  => json_encode($rating_platforms),
                'status'            => 'Rating given'
            ];

            $redirect = $this->input->post('rating') > $platformData['min_rating'] ? $platformData['rating_url'] : site_url('user-ratings/thank-you');

            $this->load->model('sent_invites_model');

            if ($this->sent_invites_model->user_ratings($update, $send_invites_id, $inviteData)) {
                $response = ['error' => false, 'message' => "We value your feedback! Thank you!", "redirect" => $redirect];
            }else{
                $response = ['error' => true, 'message' => 'Some error occurs while sending email. Try again.'];
            }

            die(json_encode($response));
        } else{
            if(empty($inviteData) || empty($inviteData)) {
                return $this->link_expired();
            }
            $data['title'] = 'User ratings';
            $data['validate'] = true;
            $data['inviteData'] = $inviteData;
            $data['platformData'] = $platformData;

            return $this->template->load('template', 'user_ratings/user_ratings', $data);
        }
    }

    public function link_expired()
    {
        $data['title'] = 'User ratings | Link Expired';
        $data['errorPage'] = true;

        return $this->template->load('template', 'user_ratings/link_expired', $data);
    }

    public function thank_you()
    {
        $data['title'] = 'User ratings | Thank you';
        $data['errorPage'] = true;

        return $this->template->load('template', 'user_ratings/thank_you', $data);
    }
}
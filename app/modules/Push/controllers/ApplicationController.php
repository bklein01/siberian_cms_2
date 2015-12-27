<?php

class Push_ApplicationController extends Application_Controller_Default
{

    public function editpostAction() {

        if($datas = $this->getRequest()->getPost()) {

            $html = '';

            try {

                $message = new Push_Model_Message();
                $message->setMessageTypeByOptionValue($this->getCurrentOptionValue()->getOptionId());
                $sendNow = false;
                $inputs = array('send_at', 'send_until');

                foreach($inputs as $input) {
                    if(empty($datas[$input.'_a_specific_datetime'])) {
                        $datas[$input] = null;
                    }
                    else if(empty($datas[$input])) {
                        throw new Exception($this->_('Please, enter a valid date'));
                    }
                    else {
                        $date = new Zend_Date($datas[$input]);
                        $datas[$input] = $date->toString('y-MM-dd HH:mm:ss');
                    }
                }

                if(empty($datas['send_at'])) {
                    $sendNow = true;
                    $datas['send_at'] = Zend_Date::now()->toString('y-MM-dd HH:mm:ss');
                }

                if(!empty($datas['send_until']) AND $datas['send_at'] > $datas['send_until']) {
                    throw new Exception($this->_("The duration limit must be higher than the sent date"));
                }

                // Récupère l'option_value en cours
                $option_value = new Application_Model_Option_Value();

                if(!empty($datas['file'])) {

                    $file = pathinfo($datas['file']);
                    $filename = $file['basename'];
                    $relative_path = $option_value->getImagePathTo();
                    $folder = Application_Model_Application::getBaseImagePath().$relative_path;
                    $img_dst = $folder.$filename;
                    $img_src = Core_Model_Directory::getTmpDirectory(true).'/'.$filename;

                    if(!is_dir($folder)) {
                        mkdir($folder, 0777, true);
                    }

                    if(!@copy($img_src, $img_dst)) {
                        throw new exception($this->_('An error occurred while saving your picture. Please try again later.'));
                    } else {
                        $datas['cover'] = $relative_path.$filename;
                    }
                }else if(!empty($data['remove_cover'])) {
                    $data['cover'] = null;
                }

                if(empty($datas['action_value'])) {
                    $datas['action_value'] = null;
                } else if(!preg_match('/^[0-9]*$/', $datas['action_value'])) {
                    $url = "http://".$datas['action_value'];
                    if(stripos($datas['action_value'], "http://") !== false || stripos($datas['action_value'], "https://") !== false) {
                        $url = $datas['action_value'];
                    }

                    $datas['action_value'] = file_get_contents("http://tinyurl.com/api-create.php?url=".urlencode($url));
                }

                $datas['type_id'] = $message->getMessageType();
                $datas['app_id'] = $this->getApplication()->getId();
                $datas["send_to_all"] = $datas["topic_receiver"]?0:1;
                $message->setData($datas)->save();

                //PnTopics
                if($datas["topic_receiver"]) {
                    $topic_data = explode(";",$datas["topic_receiver"]);

                    foreach($topic_data as $id_topic) {
                        if($id_topic != "") {
                            $category_message = new Topic_Model_Category_Message();
                            $category_message_data = array(
                                "category_id" => $id_topic,
                                "message_id" => $message->getId()
                            );
                            $category_message->setData($category_message_data);
                            $category_message->save();
                        }
                    }
                }

                if($message->getMessageType()==1) {
                    if ($sendNow) {
                        $c = curl_init();
                        curl_setopt($c, CURLOPT_URL, $this->getUrl('push/message/send', array('message_id' => $message->getId())));
                        curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);  // Follow the redirects (needed for mod_rewrite)
                        curl_setopt($c, CURLOPT_HEADER, false);         // Don't retrieve headers
                        curl_setopt($c, CURLOPT_NOBODY, true);          // Don't retrieve the body
                        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);  // Return from curl_exec rather than echoing
                        curl_setopt($c, CURLOPT_FRESH_CONNECT, true);   // Always ensure the connection is fresh

                        // Timeout super fast once connected, so it goes into async.
                        curl_setopt($c, CURLOPT_TIMEOUT, 10);
                        curl_exec($c);
                        curl_close($c);

                    }
                } else {
                    $message->updateStatus('delivered');
                }

                $html = array(
                    'success' => 1,
                    'message_timeout' => 2,
                    'message_button' => 0,
                    'message_loader' => 0
                );

                if($sendNow) $html['success_message'] = $this->_('Your message has been saved successfully and will be sent in a few minutes');
                else $html['success_message'] = $this->_('Your message has been saved successfully and will be sent at the entered date');

            }
            catch(Exception $e) {
                $html = array(
                    'message' => $e->getMessage(),
                    'message_button' => 1,
                    'message_loader' => 1
                );
            }

            $this->getLayout()->setHtml(Zend_Json::encode($html));

        }

    }

    public function cropAction() {

        if($datas = $this->getRequest()->getPost()) {
            try {
                $uploader = new Core_Model_Lib_Uploader();
                $file = $uploader->savecrop($datas);
                $datas = array(
                    'success' => 1,
                    'file' => $file,
                    'message_success' => $this->_('Info successfully saved'),
                    'message_button' => 0,
                    'message_timeout' => 2,
                );
            } catch (Exception $e) {
                $datas = array(
                    'error' => 1,
                    'message' => $e->getMessage()
                );
            }
            $this->getLayout()->setHtml(Zend_Json::encode($datas));
        }

    }

}
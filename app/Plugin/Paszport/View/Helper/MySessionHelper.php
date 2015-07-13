<?php
App::uses('SessionHelper', 'View/Helper');

class MySessionHelper extends SessionHelper
{
    public function flash($key = 'flash', $attrs = array())
    {
        $out = false;

        if (CakeSession::check('Message.' . $key)) {
            $flash = CakeSession::read('Message.' . $key);
            if (is_array($flash)) {
                foreach ($flash as $fkey => $msg) {
                    $message = $msg['message'];
//                    unset($flash[$fkey]['message']);

                    if (!empty($attrs)) {
                        $msg = array_merge($msg, $attrs);
                    }

                    if ($msg['element'] === 'default') {
                        $class = 'message';
                        if (!empty($msg['params']['class'])) {
                            $class = $msg['params']['class'];
                        }
                        $out .= '<div id="' . $key . 'Message" class="' . $class . '">' . $message . '</div>';
                    } elseif (!$msg['element']) {
                        $out .= $message;
                    } else {
                        $options = array();
                        if (isset($msg['params']['plugin'])) {
                            $options['plugin'] = $msg['params']['plugin'];
                        }
                        $tmpVars = $msg['params'];
                        $tmpVars['message'] = $message;
                        $out .= $this->_View->element($msg['element'], $tmpVars, $options);
                    }
                    CakeSession::delete('Message.' . $key . '.' . $fkey);
                }
            } else {
                $message = $flash['message'];
                unset($flash['message']);

                if (!empty($attrs)) {
                    $flash = array_merge($flash, $attrs);
                }

                if ($flash['element'] === 'default') {
                    $class = 'message';
                    if (!empty($flash['params']['class'])) {
                        $class = $flash['params']['class'];
                    }
                    $out = '<div id="' . $key . 'Message" class="' . $class . '">' . $message . '</div>';
                } elseif (!$flash['element']) {
                    $out = $message;
                } else {
                    $options = array();
                    if (isset($flash['params']['plugin'])) {
                        $options['plugin'] = $flash['params']['plugin'];
                    }
                    $tmpVars = $flash['params'];
                    $tmpVars['message'] = $message;
                    $out = $this->_View->element($flash['element'], $tmpVars, $options);
                }
                CakeSession::delete('Message.' . $key);
            }

        }

        return $out;
    }
}
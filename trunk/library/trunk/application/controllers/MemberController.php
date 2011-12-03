<?php
/**
 * MemberController
 * 
 * @author 
 * @version 
 */
class MemberController extends Libz_Base_BaseController {

    /**
     * The default action - show the home page
     */
    public function getmemberinfoAction () {
        self::getModel();
        $request = $this->getRequest();
        $member_id = $request->getParam('member_id');
        $formatted = $request->getParam('formatted');
        if ($member_id) {
            $memberInfo = $this->model->getMemberInfo($member_id);
            $issuedBook = Lib_Model_DbTable_IssueReturn::getIssuedDocumentCount(
            $member_id);
            $memberInfo['issued'] = $issuedBook;
            //$this->_helper->logger($memberInfo);
            //$this->getResponse()->setRedirect($infoURL, 303);
            /*
			if ($formatted and isset ( $memberDetail ['info'] )) {
				$formattedDetail = array ();
				foreach ( $memberDetail ['info'] as $key => $value ) {
					if (isset ( $value )) {
						$key = str_replace ( '_id', '', $key );
						$key = str_replace ( '_', ' ', $key );
						$key = ucwords ( $key );
						$formattedDetail [$key] = $value;
					}
				}
				$memberDetail ['info'] = $formattedDetail;
			}*/
            if ($memberInfo) {
                $this->_helper->json($memberInfo);
                //echo $this->_helper->json($memberInfo,false);
            } else {
                $this->getResponse()->setHttpResponseCode(400);
                echo 'Member "' . $member_id . '" not found.';
            }
        }
    }

    // NOTE: THE ABOVE AND BELOW FUNCTIONS ARE ALMOST IDENTICAL!!
    /**
     * Account Information of a member along with detailed list of books issued.
     */
    public function getaccountdetailAction () {
        self::getModel();
        $memberId = $this->getRequest()->getParam('member_id');
        if ($memberId) {
            $memberDetail = $this->model->getMemberInfo($memberId);
            if ($memberDetail) {
                $issuedBook = Lib_Model_DbTable_IssueReturn::getIssuedDocumentList(
                $memberId);
                $memberDetail['issued'] = $issuedBook;
                //$this->_helper->logger ( $memberDetail );
                $this->_helper->json($memberDetail);
            } else {
                $this->getResponse()->setHttpResponseCode(400);
                echo ' ' . $memberId . ' is not a member';
            }
        } else {
            $this->getResponse()->setHttpResponseCode(400);
            echo 'Insufficient parameters';
        }
    }

    public function accountinfoAction () {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }

    public function indexAction () 
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();  
/**
 * 
 * @todo dynamic id from auth
 */
        $id = '2308009';
        $this->view->assign('id',$id);
        
    }

 
}
?>


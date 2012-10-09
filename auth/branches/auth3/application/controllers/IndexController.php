<?php
class IndexController extends Authz_Base_BaseController
{
    /*
	public function preDispatch() {return true;
	}*/
    public function indexAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function markauthAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $this->_redirect('/index/markcore');
    }
    public function markcoreAction ()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_redirect('http://core.aceambala.com/index/bounce');
    }
    public function markacadAction ()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_redirect('http://academic.aceambala.com/index/bounce');
    }
    public function marktnpAction ()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_redirect('http://tnp.aceambala.com/index/bounce');
    }
}
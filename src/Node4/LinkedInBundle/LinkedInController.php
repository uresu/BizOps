<?php

namespace Node4\LinkedInBundle\LinkedInController;


class LinkedInController extends Controller
{
    /**
     * Login a user with LinkedIn
     *
     * @Route("/linkedin-login", name="_public_linkedin_login")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function loginAction()
    {
        $linkedIn=$this->get('linkedin');

        if ($linkedIn->isAuthenticated())
        {
            $data=$linkedIn->getUser();

            /*
             * The user is authenticated with linkedIn. I have to check in my user DB if
             * I have seen this user before or not.
             *
             * I could now:
             *  - Register the user
             *  - Login the user
             *  - Show some LinkedIn data
             */

        }

        $redirectUrl = $this->generateUrl('_public_linkedin_login', array(), true);
        $url         = $linkedIn->getLoginUrl(array('redirect_uri' => $redirectUrl));

        return $this->redirect($url);
    }
}
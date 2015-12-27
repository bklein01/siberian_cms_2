<?php

class Application_Mobile_TranslationController extends Application_Controller_Mobile_Default {

    public function findallAction() {

        $data = array();

        if(Core_Model_Language::getCurrentLanguage() != Core_Model_Language::DEFAULT_LANGUAGE) {

            Core_Model_Translator::addModule("mcommerce");
            Core_Model_Translator::addModule("comment");

            $translations = array(
                "OK",
                "Website",
                "Phone",
                "Locate",
                "Contact successfully added to your address book",
                "Unable to add the contact to your address book",
                "You must give the permission to the app to add a contact to your address book",
                "You already have this user in your contact",
                "The address you're looking for does not exists.",
                "An error occurred while loading. Please, try again later.",
                // Map
                "An unexpected error occurred while calculating the route.",
                // Mcommerce
                "Cart",
                "Proceed",
                "Next",
                "Payment",
                "Delivery",
                "My information",
                "Review",
                "Some mandatory fields are empty.",
                "Validate",
                "The payment has been cancelled, something wrong happened? Feel free to contact us.",
                // Places
                "Map",
                "Invalid place",
                "Unable to calculate the route.",
                "No address to display on map.",
                "You must share your location to access this page.",
                // Comment
                "No place to display on map.",
                "An error occurred while loading places.",

                // General
                "Load More",
                "This section is unlocked for mobile users only",
                "You have gone offline",
                "Cancel",
                "Confirm",
                "View",
                "Offline content",
                "Don't close the app while downloading. This may take a while.",
                "Do you want to download all the contents now to access it when offline? If you do, we recommend you to use a WiFi connection."
            );

            foreach($translations as $translation) {
                $data[$translation] = $this->_($translation);
            }

        }

        $this->_sendHtml($data);
    }

}

<?php

namespace App\Controller;
use Rest\Controller\RestController;

class ApiController extends RestController
{
  public function initialize() {
    $this->loadModel('Contacts');
    $this->loadModel('Companies');
  }

  public function getContact()
  {
    $id = $this->request->getQuery('id');
    $contacts = $this->Contacts->get($id);
    $this->set(compact('contacts'));
  }

  public function getContactWithCompany()
  {
    $id = $this->request->getQuery('id');
    $contacts = $this->Contacts->get($id);
    $contacts->company = $this->Companies->get($contacts->id);
    $this->set(compact('contacts'));
  }

  public function saveContact()
  {
    $error = 'Unable to save contact information';
    $success = 'success';
    $body = $this->request->input('json_decode');
    $contact = $this->Contacts->newEntity();
    $contact->first_name = $body->first_name;
    $contact->last_name = $body->last_name;
    $contact->phone_number = $body->phone_number;
    $contact->address = $body->address;
    $contact->company_id = $body->company_id;
    $contact->notes = $body->notes;
    $contact->add_notes = $body->add_notes;
    $contact->internal_notes = $body->internal_notes;
    $contact->comments = $body->comments;

    try {
        if ($this->Contacts->save($contact)) {
            $this->set(compact('contact'));
        } else {
            $this->set(compact('error'));
        }
    } catch (Exception $e) {
      $this->set(compact('error'));
    }
 
    unset($contact);
    unset($error);
  }
}

?>
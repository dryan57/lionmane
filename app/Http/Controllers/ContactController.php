<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\Telephone;
use App\Email;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::all();

                return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
                    'first_name'=>'required',
                    'last_name'=>'required',
                    'nick_name'=>'required',
                    'dob'=>'required',
                    'gender'=>'required'
                ]);
                $date = str_replace('/', '-', $request->get('dob') );
                $newDate = date("Y-m-d", strtotime($date));
                $contact = new Contact([
                    'first_name' => $request->get('first_name'),
                    'last_name' => $request->get('last_name'),
                    'nick_name' => $request->get('nick_name'),
                    'dob' => $newDate,
                    'gender' => ($request->get('gender')=='male')?1:0,
                    'image' => "",
                    'active' => 1
                ]);
                $contact->save();
                $contactToUpdate = Contact::find($contact->id);
                foreach ($request->get('phone_numbers') as $key=>$value) {
                    $telephone_type = $request->get('phone_numbers_type')[$key];
                    $telephone = new Telephone(['contact_id' => $contactToUpdate->id,'phone_number'=>$value,'category'=>$telephone_type]);
                    $contactToUpdate->telephones()->save($telephone);
                }
                foreach ($request->get('emails') as $key=>$value) {
                    $email_type = $request->get('emails_type')[$key];
                    $email = new Email(['contact_id' => $contactToUpdate->id,'email'=>$value,'category'=>$email_type]);
                    $contactToUpdate->emails()->save($email);
                }

                return redirect('/contacts')->with('success', 'Contact saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact = Contact::find($id);
        $date = str_replace('/', '-', $contact->dob);
        $newDate = date("d-m-Y", strtotime($date));
        $contact->dob = $newDate;
        return compact('contact',$contact->telephones,$contact->emails);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contact = Contact::find($id);
         $date = str_replace('/', '-', $contact->dob);
         $newDate = date("d-m-Y", strtotime($date));
         $contact->dob = $newDate;
        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $request->validate([
                     'first_name'=>'required',
                     'last_name'=>'required',
                     'nick_name'=>'required',
                     'dob'=>'required',
                     'gender'=>'required'
                ]);
                $date = str_replace('/', '-', $request->get('dob') );
                $newDate = date("Y-m-d", strtotime($date));
                $contact = Contact::find($id);
                $contact->first_name =  $request->get('first_name');
                $contact->last_name = $request->get('last_name');
                $contact->nick_name = $request->get('nick_name');
                $contact->dob = $newDate;
                $contact->gender = ($request->get('gender')=='male')?1:0;
                $contact->save();
                $telephones = $contact->telephones;
                foreach ($telephones as $telephone)
                {
                    Telephone::destroy($telephone->id);
                }
                foreach ($request->get('phone_numbers') as $key=>$value) {
                    $telephone_type = $request->get('phone_numbers_type')[$key];
                    $telephone = new Telephone(['contact_id' => $contact->id,'phone_number'=>$value,'category'=>$telephone_type]);
                    $contact->telephones()->save($telephone);
                }

              /*  foreach ($request->get('emails') as $key=>$value) {
                    $email_type = $request->get('emails_type')[$key];
                    $email = new Email(['contact_id' => $contact->id,'email'=>$value,'category'=>$email_type]);
                    $contact->emails()->save($email);
                }*/

        return redirect('/contacts')->with('success', 'Contact updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contact::find($id);
        $contact->delete();
        return redirect('/contacts')->with('success', 'Contact deleted!');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;

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

                $contact = Contact::find($id);
                $contact->first_name =  $request->get('first_name');
                $contact->last_name = $request->get('last_name');
                $contact->nick_name = $request->get('nick_name');
                $contact->dob = $request->get('dob');
                $contact->gender = ($request->get('gender')=='male')?1:0;
                $contact->save();

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

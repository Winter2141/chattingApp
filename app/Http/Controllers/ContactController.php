<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\ContactService;
use App\Service\UserService;

use App\User;


class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contacts = ContactService::doSearchFront($request->all())->get();

        if($request->ajax()){
            return view('contact.contactTable', compact('contacts'));
        }

        return view('contact.index', compact('contacts'));
    }

    public function add(Request $request)
    {
        $contacts = UserService::doSearchForContact($request->all())->get();

        if($request->ajax()){
            return view('contact.searchTable', compact('contacts'));
        }

        return view('contact.add', compact('contacts'));
    }

    public function addRequest(Request $request, $id)
    {
        if(ContactService::doCreate($id)){
            $request->session()->flash('success', 'Request Send Success');
        } else {
            $request->session()->flash('error', 'Request Send Failed');
        }
        return back();
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $status = ContactService::getContactStatus($id);

        return view('contact.show', compact('user', 'status'));
    }

    public function acceptRequest(Request $request,  $id)
    {
        if(ContactService::doAccept($id)){
            $request->session()->flash('success', 'Accepted Friend Request');
        } else {
            $request->session()->flash('error', 'Failed Accept Request');
        }
        return back();
    }

    public function rejectRequest(Request $request, $id)
    {
        if(ContactService::doReject($id))
        {
            $request->session()->flash('success', 'Reject Successfule');
        } else {
            $request->session()->flash('error', 'Reject Failed');
        }
        return back();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display contact list page
     *
     * @return View
     */
    public function createList(): View
    {
        return view('pages.contacts');
    }

    /**
     * Display adding contact page
     *
     * @return View
     */
    public function createAdd(): View
    {
        $options = [
            'action'    => 'add',
            'url'       => route('addContact'),
            'contacts'  => []
        ];

        return view('pages.contact-form')->with("options", $options);
    }

    /**
     * Display edit contact form page
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function createEdit($id): View|RedirectResponse
    {
        $contact = Contact::where('user_id', Auth::id())->where('id', $id)->first();

        if (!$contact) {
            return redirect(route('contacts'))->with('error', 'Cannot update contact record. Contact not found!');
        }

        $options = [
            'action'    => 'edit',
            'url'       => route('editContact', ['id' => $id]),
            'contacts'  => $contact
        ];
        return view('pages.contact-form')->with("options", $options);
    }

    /**
     * Request on adding new contact record
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function add(Request $request): RedirectResponse
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'company'   => ['nullable', 'string', 'max:255'],
            'phone'     => ['nullable', 'string', 'max:30'],
            'email'     => ['nullable', 'string', 'lowercase', 'email', 'max:100'],
        ]);

        $contact = Contact::create([
            'user_id'   => Auth::id(),
            'name'      => $request->name,
            'company'   => $request->company,
            'phone'     => $request->phone,
            'email'     => $request->email,
        ]);

        session()->flash('success', 'New contact was successfully added!');

        return redirect(route('contacts'));
    }

    /**
     * Request on editing contact records
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'company'   => ['nullable', 'string', 'max:255'],
            'phone'     => ['nullable', 'string', 'max:30'],
            'email'     => ['nullable', 'string', 'lowercase', 'email', 'max:100'],
        ]);

        $contact = Contact::where('user_id', Auth::id())->where('id', $id)->first();

        if (!$contact) {
            return redirect(route('contacts'))->with('error', 'Cannot update contact record. Contact not found!');
        }

        $contact->update([
            'user_id'   => Auth::id(),
            'name'      => $request->name,
            'company'   => $request->company,
            'phone'     => $request->phone,
            'email'     => $request->email,
        ]);

        session()->flash('success', 'Contact record was successfully updated!');

        return redirect(route('contacts'));
    }

    /**
     * Request on deleting contact record
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function delete($id): RedirectResponse
    {
        $contact = Contact::where('user_id', Auth::id())->where('id', $id)->first();

        if ($contact) {
            $contact->delete();
            session()->flash('success', 'Contact deleted successfully.');

            return redirect(route('contacts'));
        }

        return back()->with('error', 'Cannot delete contact record. Contact not found!');
    }
}

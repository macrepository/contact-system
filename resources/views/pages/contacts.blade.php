@extends('layouts.app')

@section('content')
<div>
    <div>
        <div class="d-flex justify-content-end">
            <div class="input-group mb-3 w-50">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input id="searchContact" name="searchContact" type="text" class="form-control border-start-0 border-end-0" placeholder="Search" onkeyup="searchContact(this)">
                <span class="input-group-text" id="clearSearch" role="button" onclick="clearSearchInput()"><i class="bi bi-x-circle-fill"></i></span>
            </div>
        </div>
        <div>
            <table class="table table-bordered border-dark">
                <thead>
                    <tr class="table-dark">
                        <th>NAME</th>
                        <th>COMPANY</th>
                        <th>PHONE</th>
                        <th>EMAIL</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="contactTableData">
                    <!-- Body row data will be inserted here -->
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            <ul id="pagination" class="pagination">
                <!-- Pagination will be inserted here -->
            </ul>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalPoup" tabindex="-1" aria-labelledby="modalPoupLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body">
                    <p>Are you sure you want to DELETE?</p>
                    <input type="hidden" id="contactIdToDelete" name="contactIdToDelete">
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary ps-5 pe-5" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary ps-5 pe-5" onclick="confirmedToDelete()">Yes</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var popup;
    var modalPopup;
    var numOfContactDisplayOnCurrentPage;
    var currentContactPage;
    var inputSearchContact = '';

    const pageSize = 7;
    const maxPageControl = 3;

    document.addEventListener("DOMContentLoaded", () => {
        removeMessages();
        displayContacts(inputSearchContact, 1);
        popup = document.getElementById('modalPoup');
        modalPopup = new bootstrap.Modal(popup, {
            keyboard: false
        });
    });

    function removeMessages() {
        const messagesArea = document.getElementById('messages-area');
        setInterval(() => {
            messagesArea.innerHTML = '';
        }, 3000);
    }

    async function displayContacts(search, currentPage) {
        const response = await getContacts(search, currentPage, pageSize);
        if (!response) {
            noResult();
            return;
        }

        const contacts = response.data;
        renderContacts(contacts);
        renderPagination(currentPage, response.totalPages);
        currentContactPage = currentPage;
        numOfContactDisplayOnCurrentPage = contacts.length;
    }

    function searchContact(element) {
        inputSearchContact = element.value;
        displayContacts(inputSearchContact, 1);
    }

    function clearSearchInput() {
        inputSearchContact = '';
        document.getElementById('searchContact').value = inputSearchContact;
        displayContacts(inputSearchContact, 1);
    }

    function noResult() {
        const contactView = document.getElementById('contactTableData');
        contactView.innerHTML = '';
        const pagination = document.getElementById('pagination');
        pagination.innerHTML = '';
    }

    function renderContacts(contacts) {
        const contactView = document.getElementById('contactTableData');
        const rows = contacts.map(contact => `
            <tr>
                <td class="align-middle">${contact.name}</td>
                <td class="align-middle">${contact.company ?? ''}</td>
                <td class="align-middle">${contact.phone ?? ''}</td>
                <td class="align-middle">${contact.email ?? ''}</td>
                <td class="align-middle d-flex column-gap-1 justify-content-center align-items-center">
                    <a class="btn btn-primary" href="/contact/edit/${contact.id}">Edit</a>
                    <span class="vr"></span>
                    <form id="deleteContactForm${contact.id}" method="POST" action="/contact/${contact.id}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" onclick="confirmingDeletion(event, ${contact.id})">Delete</button>
                    </form>
                </td>
            </tr>
        `).join('');
        contactView.innerHTML = rows;
    }

    function renderPagination(currentPage, totalPages) {
        const pagination = document.getElementById('pagination');

        if (totalPages <= 1) {
            pagination.innerHTML = '';
        } else {
            pagination.innerHTML = createPaginationControls(currentPage, totalPages);
        }
    }

    function createPaginationControls(currentPage, maxPage) {
        let controls = '';
        if (currentPage > 1) {
            controls += `<li class="page-item"><a href="#" class="page-link" onclick="prevPageControl(${currentPage - 1})">Prev</a></li>`;
        }

        let startPage = Math.floor((currentPage - 1) / maxPageControl) * maxPageControl + 1;

        for (let i = startPage; i < startPage + maxPageControl && i <= maxPage; i++) {
            controls += `<li class="page-item"><a href="#" class="page-link ${i === currentPage ? 'active' : ''}" onclick="showPageControl(${i})">${i}</a></li>`;
        }

        if (currentPage < maxPage) {
            controls += `<li class="page-item"><a href="#" class="page-link" onclick="nextPageControl(${currentPage + 1})">Next</a></li>`;
        }

        return controls;
    }

    function prevPageControl(prevPage) {
        displayContacts(inputSearchContact, prevPage);
    }

    function showPageControl(controlPage) {
        displayContacts(inputSearchContact, controlPage);
    }

    function nextPageControl(nextPage) {
        displayContacts(inputSearchContact, nextPage);
    }

    async function getContacts(search, page, limit) {
        const params = new URLSearchParams({
            search,
            page,
            limit
        });

        return await request(`/api/contacts?${params}`, 'GET');
    }

    async function request(url, method, paramHeaders) {
        try {
            const headers = {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                ...paramHeaders
            };

            const response = await fetch(url, {
                method,
                headers
            });

            if (!response.ok) throw new Error("HTTP error, status = " + response.status);

            return await response.json();
        } catch (error) {
            console.error("Error fetching data", error);
        }
    }

    function confirmedToDelete() {
        const contactId = document.getElementById('contactIdToDelete').value;

        if (!contactId) {
            alert("Something went wrong. Please reload the page!");
        }

        document.getElementById('deleteContactForm' + contactId).submit();
    }

    function confirmingDeletion(event, contactId) {
        event.preventDefault();

        if (popup && modalPopup) {
            document.getElementById('contactIdToDelete').value = contactId;
            modalPopup.show(popup);
        } else {
            const response = window.confirm("Are you sure you want to DELETE?");
            if (response) {
                document.getElementById('deleteContactForm' + contactId).submit();
            }
        }
    }
</script>
@endsection
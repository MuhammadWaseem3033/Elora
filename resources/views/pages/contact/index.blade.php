@extends('layouts.app')

@section('title', 'Contact Us | ÉLORA')

@section('meta_description', 'Get in touch with the ÉLORA editorial team for questions, collaborations and general
    enquiries.')

@section('content')

    <section class="page-hero">
        <span class="eyebrow">ÉLORA / GET IN TOUCH</span>
        <h1>Contact Us</h1>
        <p>
            Have a question, collaboration idea or something to share?
            We would love to hear from you.
        </p>
    </section>

    <section class="section container">

        <div class="row g-5">

            <div class="col-lg-4">
                <span class="eyebrow">SAY HELLO</span>
                <h2>Let's Connect</h2>

                <p>
                    Whether you have a fashion story, editorial enquiry,
                    partnership proposal or general feedback, send us
                    a message using the form.
                </p>

                <p>
                    <strong>ÉLORA</strong><br>
                    Independent Fashion & Style Journal
                </p>
            </div>

            <div class="col-lg-8">

                <form id="contactForm" action="{{ route('contact.store') }}" method="POST">

                    @csrf

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label for="name" class="form-label">Full Name *</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Your name"
                                maxlength="120" required>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" name="email" id="email" class="form-control"
                                placeholder="Your email" maxlength="255" required>
                        </div>

                        <div class="col-12">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control"
                                placeholder="Message subject" maxlength="150">
                        </div>

                        <div class="col-12">
                            <label for="message" class="form-label">Your Message *</label>
                            <textarea name="message" id="message" class="form-control" rows="7" maxlength="5000"
                                placeholder="Write your message here..." required></textarea>
                        </div>

                        <div class="col-12">
                            <div id="contactResponse" role="status" aria-live="polite"></div>

                            <button type="submit" id="contactSubmit" class="btn btn-dark">
                                Send Message
                            </button>
                        </div>

                    </div>

                </form>

            </div>

        </div>

    </section>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const form = document.getElementById('contactForm');

            if (!form) return;

            const submitButton = document.getElementById('contactSubmit');
            const responseBox = document.getElementById('contactResponse');

            form.addEventListener('submit', async function(event) {

                event.preventDefault();

                responseBox.innerHTML = '';

                submitButton.disabled = true;
                submitButton.textContent = 'Sending...';

                try {

                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: new FormData(form)
                    });

                    const data = await response.json();

                    if (!response.ok) {

                        if (response.status === 422 && data.errors) {
                            const errors = Object.values(data.errors).flat();

                            responseBox.innerHTML = `
                        <div class="alert alert-danger">
                            ${errors.map(error =>
                                `<div>${escapeHtml(error)}</div>`
                            ).join('')}
                        </div>
                    `;
                        } else {
                            responseBox.innerHTML = `
                        <div class="alert alert-danger">
                            ${escapeHtml(data.message || 'Something went wrong. Please try again.')}
                        </div>
                    `;
                        }

                        return;
                    }

                    responseBox.innerHTML = `
                <div class="alert alert-success">
                    ${escapeHtml(data.message)}
                </div>
            `;

                    form.reset();

                } catch (error) {

                    responseBox.innerHTML = `
                <div class="alert alert-danger">
                    Unable to send your message. Please try again.
                </div>
            `;

                } finally {

                    submitButton.disabled = false;
                    submitButton.textContent = 'Send Message';

                }

            });

            function escapeHtml(value) {
                const div = document.createElement('div');
                div.textContent = value;
                return div.innerHTML;
            }

        });
    </script>
@endpush

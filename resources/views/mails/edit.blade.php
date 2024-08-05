<x-layout theTitle="Edit Mail" href="/mails/{{ $mail->id }}">
    <div class="row">
        <div class="col-12 justify-center">
            <div class="card">

                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->

                    <!-- Profile Edit Form -->
                    <x-forms.form method="POST" action='/mails/send/{{$worker->id}}'
                        enctype="multipart/form-data" novalidate>
                        <x-forms.input label="Sender" name="sender" value="{{ Auth::user()->email }}" />
                        <x-forms.input type="email" name="recipient" value="{{ $mail->recipient }}"
                            label="Recipient Email" placeholder="dg@examplemail...com" />
                        <x-forms.input name="subject" label="Subject" value="{{ $mail->subject }}"
                            placeholder="Subject" />
                        <x-forms.field label="Message" name="">
                            <textarea cols="50" rows="4" name="body" value={{ $mail->body }}></textarea>

                        </x-forms.field>

                        <x-forms.button class="w-50">Resend Mail</x-forms.button>
                    </x-forms.form><!-- End Profile Edit Form -->


                </div>

            </div>
            <div class="mt-2 mx-3 justify-content-center">
                <div>
                    <x-forms.form method="POST" action="/mails/send/{{$mail->id}}">
                        @method('DELETE')
                        @csrf
                        <input type="text" value="{{$mail->id}}">
                        <x-forms.button class="btn btn-danger">Delete Mail</x-forms.button>
                    </x-forms.form>
                </div>
            </div>
        </div>
    </div>
</x-layout>

<!-- End Bordered Tabs -->

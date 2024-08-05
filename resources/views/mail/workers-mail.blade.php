
<x-layout theTitle="Send Mail" href="/mails/send">
    <div class="row">
             <div class="col-xl-8">
            <div class="card">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->

                    <!-- Profile Edit Form -->
                    <x-forms.form method="POST" action='/mails/send/{{$worker->id}}' enctype="multipart/form-data"
                        novalidate>
                        <x-forms.input label="Sender" name="sender" value="{{Auth::user()->email}}"/>
                        <x-forms.input type="email" name="recipient" label="Recipient Email" placeholder="dg@examplemail...com" />
                        <x-forms.input name="subject" label="Subject" placeholder="Subject" />
                        <x-forms.field label="Message" name="">
                            <textarea cols="50" rows="4" name="body"></textarea>

                        </x-forms.field>

                        <x-forms.button class="w-100">Send Mail</x-forms.button>
                    </x-forms.form><!-- End Profile Edit Form -->


                </div>
            </div>
        </div>
    </div>
</x-layout>

<!-- End Bordered Tabs -->

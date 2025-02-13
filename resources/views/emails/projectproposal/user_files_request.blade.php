<b>PLEASE NOTE! </b>
<br>
<b>ProjectProposal is currently in test mode, and all created proposals are fictitious and intended for testing purposes only.</b>
<br><br>
---
<br>
To User(Project proposer)
<br>
---
<br>
Your Project Proposal Submitted for Review has been preapproved<br><br>
Dear {{$user->name}},
<br><br>
Your project proposal, submitted on {{Carbon\Carbon::createFromTimestamp($dashboard->created)->format('Y-m-d')}},
has been reviewed by the Unit Head(s) and the Vice Head and has been reapproved for further processing.
<br><br>
Please upload the <strong>DSV budget file</strong>, a <strong>short description of the proposal</strong>, and any <strong>additional relevant files</strong> for review by the <strong>Financial Officer</strong>.
<br><br>
Here's a quick overview of the request:
<br><br>
<b>Proposal:</b> {{$dashboard->name}}
<br><br>
<b>Requester:</b> {{$user->name}}
<br><br>
<b>Unit Head(s):</b>
@foreach($dashboard->unit_heads as $head)
{{ \App\Models\User::find($head)->name }}
,
@endforeach
<br><br>
<b>Created:</b> {{Carbon\Carbon::createFromTimestamp($dashboard->created)->format('Y-m-d')}}
<br><br>
<b>Approved by vice head:</b> {{Carbon\Carbon::parse($dashboard->updated_at)->format('Y-m-d')}}
<br><br>
<b>ProposalID:</b> {{$dashboard->request_id}}
<br><br>
You can review the details and upload the requested files by accessing the proposal through the following link:
<br><br>
<a href="{{ url('') }}/pp/stage2_upload_pp/{{$dashboard->request_id}}">Direct link to {{$dashboard->name}}</a>
<br><br>
---
<br>
This is an automated email, please do not reply to this email.

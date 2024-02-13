[DSV Intranet: Role Update Notification]<br><br>

Dear <b>{{$user->name}}</b>,
<br><br>
We would like inform you that your account and roles have been updated in our system. Your new responsibilities and privileges are now active.
<br><br>
Please review your updated roles and ensure that you have the necessary access and permissions to carry out your tasks effectively.
If you have any questions or require further information about your updated roles, please don't hesitate to contact our product owner or support.
<br><br>
Your roles have been updated to:
<br><br>
@foreach($user->roles() as $role)
    <b>
        @if($role->title == 'staff_education')
            STAFF - Create, edit, and publish digital content, including articles, news posts, images, and other assets within education.
        @elseif ($role->title == 'staff_administration')
            ADMIN - Create, edit, and publish digital content, including articles, news posts, images, and other assets within administration.
        @elseif ($role->title == 'staff_phd')
            PHD - Create, edit, and publish digital content, including articles, news posts, images, and other assets within phd.
        @elseif ($role->title == 'staff_research')
            RESEARCH - Create, edit, and publish digital content, including articles, news posts, images, and other assets within research.
        @elseif ($role->title == 'staff_premises')
            PREMISES - Create, edit, and publish digital content, including articles, news posts, images, and other assets within premises.
        @elseif ($role->title == 'staff_it')
            IT - Create, edit, and publish digital content, including articles, news posts, images, and other assets within it.
        @elseif ($role->title == 'financial_officer')
            FINACIAL OFFICER - Review, grant, deny or return user requests for the DSV department.
        @elseif ($role->title == 'project_leader')
            PROJECT LEADER - Review, grant, deny or return user requests within your project group.
        @elseif ($role->title == 'unit_head')
            UNIT HEAD - Review, grant, deny or return user requests within your unit.
        @elseif ($role->title == 'site_administrator')
            ADMINISTRATOR - Full administrative access to the CMS - managing, configuring, and maintaining the CMS.  User management and role assignment - ensuring user roles and permissions are properly set up.
        @endif
    </b>
    <br><br>
@endforeach
<br>
---
<br>
This is an automated email, please do not reply to this email.

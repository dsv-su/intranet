DSV Intranet: Role Update Notification<br><br>

Dear <b>{{$user->name}}</b>,
<br><br>
We would like to inform you that your account and roles have been updated. Your new permissions are now active.
<br><br>
Please review your updated roles and ensure that you have the necessary access and permissions to carry out your tasks effectively.
If you have any questions or require further information about your updated roles, please don't hesitate to contact our product owner, Tuija Lehtonen (tuija@dsv.su.se), or support.
<br><br>
Your roles have been updated to:
<br><br>
@foreach($user->roles() as $role)
    <b>
        @if($role->title == 'staff_education')
            STAFF - Manage the creation, editing, and publishing of digital content, encompassing articles, news posts, images, and other assets within the education sector.
        @elseif ($role->title == 'staff_administration')
            ADMIN - Create, edit, and publish digital content, such as articles, news posts, images, and other assets, within administrative contexts.
        @elseif ($role->title == 'staff_phd')
            PHD - Create, edit, and publish digital content, encompassing articles, news posts, images, and other assets within the realm of PhD studies.
        @elseif ($role->title == 'staff_research')
            RESEARCH - Create, edit, and publish digital content, including articles, news posts, images, and other assets within the field of research.
        @elseif ($role->title == 'staff_premises')
            PREMISES - Create, edit, and publish digital content, such as articles, news posts, images, and other assets related to premises.
        @elseif ($role->title == 'staff_it')
            IT - Create, edit, and publish digital content, including articles, news posts, images, and other assets within the IT domain.
        @elseif ($role->title == 'financial_officer')
            FINACIAL OFFICER - Review, approve, deny, or return user requests for the DSV department.
        @elseif ($role->title == 'project_leader')
            PROJECT LEADER - Review, approve, deny, or return user requests within your project group.
        @elseif ($role->title == 'unit_head')
            UNIT HEAD - Review, grant, deny, or return user requests within your unit.
        @elseif ($role->title == 'site_administrator')
            ADMINISTRATOR - Full administrative access to the CMS, including managing, configuring, and maintaining the system. Responsibilities also include user management and role assignment, ensuring that user roles and permissions are correctly configured.
        @endif
    </b>
    <br><br>
@endforeach
<br>
---
<br>
This is an automated email. Please do not reply to this message.

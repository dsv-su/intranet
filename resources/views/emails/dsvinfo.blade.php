{{ $news->title }}
<br><br>
{!! $news->content !!}
<br><br>
Author: {{$news->author->name}}
<br><br>
You can read the entire post at: <a href="{{ url('') }}{{ $news->uri }}">{{url('')}}{{$news->uri}}</a>
<br><br>
@if( collect($news->dsv_attachments)->isNotEmpty() )
    This email contains an attachment
    <br><br>

    @foreach($news->dsv_attachments as $attach)
        Title: {{$attach->title}}<br>
        Download at: <a href="{{url('')}}{{$attach->url}}">Download attachment</a>
        <br><br>
    @endforeach
@endif


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Posts</title>
</head>
<body style="padding: 15px">

    <h1>Posts</h1>
    <hr>
    <div style="padding: 20px">
        @foreach($posts as $post)

            <p>Title : {{ $post->title }}</p>
            <p>Creator : {{ $post->user->name }}</p>
            <p>Body : {{ $post->body }}</p>
            <p>Commnends :</p>
            <div style="padding: 20px">
                @foreach($post->commends as $commend)
                    <p>Name : {{ $commend->user->name }}</p>
                    <p>Message : {{ $commend->message }}</p>
                @endforeach
            </div>
            <br>
        @endforeach
    </div>

</body>
</html>

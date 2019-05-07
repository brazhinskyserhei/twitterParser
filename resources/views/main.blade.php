<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Parser Twitter</title>
</head>
<body>
<div class="container">
    <div class="row mt-3">
        <form class="form-inline" action="{{route('twitter-users.store')}}" method="POST">
            @csrf
            @method('POST')
            <label for="email2" class="mb-2 mr-sm-2">Имя аккаунта:</label>
            <input type="text" class="form-control mb-2 mr-sm-2" id="email2" placeholder="Имя аккаунта" name="name">
            <button type="submit" class="btn btn-primary mb-2">Отправить</button>
        </form>
    </div>

    @if ($errors->any())
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
<div class="container-fluid">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col" >PhotoURL</th>
            <th scope="col">Image</th>
            <th scope="col">Name</th>
            <th scope="col">TwitterID</th>
            <th scope="col">Description</th>
            <th scope="col">Tweets</th>
            <th scope="col">Following</th>
            <th scope="col">Followers</th>
            <th scope="col">Likes</th>
        </tr>
        </thead>
        <tbody>

        @foreach($users as $user)
            <tr>
                <th scope="row">{{$user->id}}</th>
                <td>
                    <a href="{{$user->photo}}">{{$user->photo}}</a>
                </td>
                <td>
                    <img src="{{$user->photo}}" width="80px">
                </td>
                <td>{{$user->name}}</td>
                <td>{{$user->twitter_id}}</td>
                <td>{{$user->description}}</td>
                <td>{{$user->tweets}}</td>
                <td>{{$user->following}}</td>
                <td>{{$user->followers}}</td>
                <td>{{$user->likes}}</td>
            </tr>
        @endforeach()
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>
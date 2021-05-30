<!DOCTYPE html>
<html>
<head>
    <title>Chat</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script>
</head>
<!--Coded With Love By Mutiullah Samim-->
<body>
<div class="container-fluid h-100">
    <div class="container py-5 px-4">
        <!-- For demo purpose-->
        <header class="text-center">
            <h1 class="display-4 text-white">Bootstrap Chat</h1>
            <p class="text-white lead mb-0">An elegant chat widget compatible with Bootstrap 4</p>
            <p class="text-white lead mb-4">Snippet by
                <a href="https://bootstrapious.com" class="text-white">
                    <u>Bootstrapious</u></a>
            </p>
        </header>

        <div class="row rounded-lg overflow-hidden shadow">
            <!-- Users box-->
            <div class="col-5 px-0">
                <div class="bg-white">

                    <div class="bg-gray px-4 py-2 bg-light">
                        <p class="h5 mb-0 py-1">Recent</p>
                    </div>

                    <div class="messages-box">
                        <div class="list-group rounded-0">
                            <a class="list-group-item list-group-item-action active text-white rounded-0">
                                <div class="media"><img src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg" alt="user" width="50" class="rounded-circle">
                                    <div class="media-body ml-4">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <h6 class="mb-0">Jason Doe</h6><small class="small font-weight-bold">25 Dec</small>
                                        </div>
                                        <p class="font-italic mb-0 text-small">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
                                    </div>
                                </div>
                            </a>

                            <a href="#" class="list-group-item list-group-item-action list-group-item-light rounded-0">
                                <div class="media"><img src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg" alt="user" width="50" class="rounded-circle">
                                    <div class="media-body ml-4">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <h6 class="mb-0">Jason Doe</h6><small class="small font-weight-bold">14 Dec</small>
                                        </div>
                                        <p class="font-italic text-muted mb-0 text-small">Lorem ipsum dolor sit amet, consectetur. incididunt ut labore.</p>
                                    </div>
                                </div>
                            </a>

                            <a href="#" class="list-group-item list-group-item-action list-group-item-light rounded-0">
                                <div class="media"><img src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg" alt="user" width="50" class="rounded-circle">
                                    <div class="media-body ml-4">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <h6 class="mb-0">Jason Doe</h6><small class="small font-weight-bold">9 Nov</small>
                                        </div>
                                        <p class="font-italic text-muted mb-0 text-small">consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
                                    </div>
                                </div>
                            </a>

                            <a href="#" class="list-group-item list-group-item-action list-group-item-light rounded-0">
                                <div class="media"><img src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg" alt="user" width="50" class="rounded-circle">
                                    <div class="media-body ml-4">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <h6 class="mb-0">Jason Doe</h6><small class="small font-weight-bold">18 Oct</small>
                                        </div>
                                        <p class="font-italic text-muted mb-0 text-small">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
                                    </div>
                                </div>
                            </a>

                            <a href="#" class="list-group-item list-group-item-action list-group-item-light rounded-0">
                                <div class="media"><img src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg" alt="user" width="50" class="rounded-circle">
                                    <div class="media-body ml-4">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <h6 class="mb-0">Jason Doe</h6><small class="small font-weight-bold">17 Oct</small>
                                        </div>
                                        <p class="font-italic text-muted mb-0 text-small">consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
                                    </div>
                                </div>
                            </a>

                            <a href="#" class="list-group-item list-group-item-action list-group-item-light rounded-0">
                                <div class="media"><img src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg" alt="user" width="50" class="rounded-circle">
                                    <div class="media-body ml-4">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <h6 class="mb-0">Jason Doe</h6><small class="small font-weight-bold">2 Sep</small>
                                        </div>
                                        <p class="font-italic text-muted mb-0 text-small">Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                    </div>
                                </div>
                            </a>

                            <a href="#" class="list-group-item list-group-item-action list-group-item-light rounded-0">
                                <div class="media"><img src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg" alt="user" width="50" class="rounded-circle">
                                    <div class="media-body ml-4">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <h6 class="mb-0">Jason Doe</h6><small class="small font-weight-bold">30 Aug</small>
                                        </div>
                                        <p class="font-italic text-muted mb-0 text-small">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
                                    </div>
                                </div>
                            </a>

                            <a href="#" class="list-group-item list-group-item-action list-group-item-light rounded-0">
                                <div class="media"><img src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg" alt="user" width="50" class="rounded-circle">
                                    <div class="media-body ml-4">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="mb-0">Jason Doe</h6><small class="small font-weight-bold">21 Aug</small>
                                        </div>
                                        <p class="font-italic text-muted mb-0 text-small">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
                                    </div>
                                </div>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Chat Box-->
            <div class="col-7 px-0">
                <div class="px-4 py-5 chat-box bg-white">
                    <!-- Sender Message-->
                    <div class="media w-50 mb-3"><img src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg" alt="user" width="50" class="rounded-circle">
                        <div class="media-body ml-3">
                            <div class="bg-light rounded py-2 px-3 mb-2">
                                <p class="text-small mb-0 text-muted">Test which is a new approach all solutions</p>
                            </div>
                            <p class="small text-muted">12:00 PM | Aug 13</p>
                        </div>
                    </div>

                    <!-- Reciever Message-->
                    <div class="media w-50 ml-auto mb-3">
                        <div class="media-body">
                            <div class="bg-primary rounded py-2 px-3 mb-2">
                                <p class="text-small mb-0 text-white">Test which is a new approach to have all solutions</p>
                            </div>
                            <p class="small text-muted">12:00 PM | Aug 13</p>
                        </div>
                    </div>

                    <!-- Sender Message-->
                    <div class="media w-50 mb-3"><img src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg" alt="user" width="50" class="rounded-circle">
                        <div class="media-body ml-3">
                            <div class="bg-light rounded py-2 px-3 mb-2">
                                <p class="text-small mb-0 text-muted">Test, which is a new approach to have</p>
                            </div>
                            <p class="small text-muted">12:00 PM | Aug 13</p>
                        </div>
                    </div>

                    <!-- Reciever Message-->
                    <div class="media w-50 ml-auto mb-3">
                        <div class="media-body">
                            <div class="bg-primary rounded py-2 px-3 mb-2">
                                <p class="text-small mb-0 text-white">Apollo University, Delhi, India Test</p>
                            </div>
                            <p class="small text-muted">12:00 PM | Aug 13</p>
                        </div>
                    </div>

                    <!-- Sender Message-->
                    <div class="media w-50 mb-3"><img src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg" alt="user" width="50" class="rounded-circle">
                        <div class="media-body ml-3">
                            <div class="bg-light rounded py-2 px-3 mb-2">
                                <p class="text-small mb-0 text-muted">Test, which is a new approach</p>
                            </div>
                            <p class="small text-muted">12:00 PM | Aug 13</p>
                        </div>
                    </div>

                    <!-- Reciever Message-->
                    <div class="media w-50 ml-auto mb-3">
                        <div class="media-body">
                            <div class="bg-primary rounded py-2 px-3 mb-2">
                                <p class="text-small mb-0 text-white">Apollo University, Delhi, India Test</p>
                            </div>
                            <p class="small text-muted">12:00 PM | Aug 13</p>
                        </div>
                    </div>

                </div>

                <!-- Typing area -->
                <form action="#" class="bg-light">
                    <div class="input-group">
                        <input type="text" placeholder="Type a message" aria-describedby="button-addon2" class="form-control rounded-0 border-0 py-4 bg-light">
                        <div class="input-group-append">
                            <button id="button-addon2" type="submit" class="btn btn-link"> <i class="fa fa-paper-plane"></i></button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>
</body>
</html>

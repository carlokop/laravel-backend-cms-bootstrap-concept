<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">{{$title}}</h2>
            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        @php
                            $uri = Request::path();
                            $uriArray = explode('/', $uri);
                            $url = '';
                            //check if any is an id number and remove from array
                            for($i=0; $i < count($uriArray); $i++) {
                                if(is_numeric ( $uriArray[$i] )) {
                                    array_splice($uriArray, $i,1);
                                }
                            }
                        @endphp
                        @for($i=0; $i<count($uriArray); $i++)
                            @php 
                                $url = $url . '/'.$uriArray[$i]; 
                                //var_dump($uriArray);
                            @endphp
                            @if($i == count($uriArray)-1)
                                <li class="breadcrumb-item active" aria-current="page">{{$title}}</li>
                            @else
                                @if($i == 0)
                                    <li class="breadcrumb-item"><a href="{{$url}}" class="breadcrumb-link">Dashboard</a></li>
                                @else
                                    <li class="breadcrumb-item"><a href="{{$url}}" class="breadcrumb-link">{{$cats[$i-1]}}</a></li>
                                @endif
                            @endif
                        @endfor                       
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
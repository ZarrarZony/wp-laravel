<div class="innerContainer">
    <div class="blogBanner">
        <a href="javascript:;" class="bannerImage">
            <img src="build/images/forbes.jpg" alt="">
        </a>
    </div>

    <div class="blogStories">
        <h1 class="pageTitle">Recent Stories</h1>
        @foreach($site_blogs as $blogs)
        <div class="blogPost">
            <a href="javascript:;" class="postImage">
                <img src="{{ asset('build/images/blogs/forbes.jpg') }}" alt="test">
            </a>
            <div class="contentPost">
                <h2>{{ $blogs['title'] }}</h2>
                <div class="contDetail">
                    <span class="tags">
                        <span>Fashion,Design,Expo</span>
                    </span>                   
                    <span class="date">{{ date('M-d-Y', strtotime($blogs['created_at'])) }}</span>                   
                    <span class="userName">
                        By <span>admin</span>
                    </span>                   
                </div>
                <div class="desTxt">
                    <p class="blogText">{!! $blogs['content'] !!} </p>
                    <a href="javascript:;" class="link">Read more</a>
                </div>
            </div>
        </div>
         @endforeach
    </div>
</div>
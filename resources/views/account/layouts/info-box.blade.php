<div class="header-info-box">
                    <span><span class="icon"></span><strong>TÀI KHOẢN:</strong> {{Auth::user()->username}}</span>
                    <span><span class="icon"></span><strong>XU NẠP:</strong>
                        {{number_format(Auth::user()->balance)}}</span>
                    {{-- <span><span class="icon"></span><strong>XU WAR:</strong> {{ number_format(Auth::user()->war_point -
                        Auth::user()->war_point_used) }}</span>
                    <span><span class="icon"></span><strong>XU EVENT:</strong>{{number_format(Auth::user()->xu_event -
                        Auth::user()->xu_event_used)}}</span>
                 --}}
                 </div>
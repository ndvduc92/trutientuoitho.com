@extends('layouts.master')
@section('content')
<style>
    .highlight {
    color: #e74c3c;
    font-weight: bold;
    box-shadow: 0 0 0 0 rgba(46, 204, 113, 0.7);
  }
    .ingame-activity {
        padding: 20px;
        margin-bottom: 200px;
        overflow: auto;
    }

    .ingame-activity h2 {
        font-size: 22px;
        color: #6b2d0a;
        margin-bottom: 15px;
        text-align: center;
        margin-top: -40px;
    }

    .ingame-activity img {
        width: 200px !important;
        display: block;
        margin: 0 auto;
    }

    /* Tabs ngang */
    .tabs-horizontal {
        display: flex;
        justify-content: center;
        border-bottom: 2px solid #eee;
        margin-bottom: 15px;
    }

    .tab-btn {
        background: #eee;
        border: none;
        padding: 10px 20px;
        margin: 0 5px;
        cursor: pointer;
        border-radius: 6px 6px 0 0;
        transition: 0.3s;
        font-weight: bold;
    }

    .tab-btn.active {
        background: #6b2d0a;
        color: #fff;
    }

    .tab-content-wrapper {
        flex: 1;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .log-box {
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 12px;
        overflow-y: auto;
        font-family: monospace;
        font-size: 14px;
        line-height: 1.6;
    }

    .log-entry {
        padding: 10px 0;
        border-bottom: 1px dashed #ddd;
    }

    .log-entry:last-child {
        border-bottom: none;
    }

    .log-entry .boss {
        color: #d9534f;
        font-weight: bold;
    }

    .log-entry .win {
        color: #28a745;
        font-weight: bold;
    }
</style>

<div class="account-section">
    <div class="account-section-title">
        ⚔️ Hoạt động <small style="color: gray; font-size:14px; font-style:italic"> (<a href="?refresh=true">Làm mới</a>)</small>
    </div>
    <section class="ingame-activity container">

        <!-- Tabs ngang -->
        {{-- <div class="tabs-horizontal">
            <button class="tab-btn active" data-tab="boss">🐉 Boss</button>
            <button class="tab-btn" data-tab="pvp">⚔️ PvP</button>
        </div> --}}

        <!-- Nội dung log -->
        <div class="tab-content-wrapper">
            <!-- Tab Boss -->
            <div class="tab-content active" id="boss">
                <div class="log-box">
                    @foreach ($pks as $item)
                    <div class="log-entry">
                        {!! $item["msg"] !!} <span class="description" style="color: gray"> -
                            {{ timeAgo($item["date"])['time'] }}
                            <small>
                                ({{ timeAgo($item["date"])['showDate'] ?
                                Carbon\Carbon::parse($item["date"])->format('d/m/Y H:i:s') :
                                Carbon\Carbon::parse($item["date"])->format('H:i:s') }})</small>
                        </span>
                    </div>
                    @endforeach



                </div>
            </div>

            <!-- Tab PvP -->
            <div class="tab-content" id="pvp">
                <div class="log-box">
                    <div class="log-entry">[15:40] <strong>Thiên Vũ</strong> PK <strong>Ngọc Nhi</strong> → <span
                            class="win">Thiên Vũ thắng</span></div>
                </div>
            </div>
        </div>
    </section>
</div>


<script>
    document.querySelectorAll(".tab-btn").forEach(btn => {
    btn.addEventListener("click", function () {
      document.querySelectorAll(".tab-btn").forEach(b => b.classList.remove("active"));
      document.querySelectorAll(".tab-content").forEach(c => c.classList.remove("active"));

      this.classList.add("active");
      document.getElementById(this.dataset.tab).classList.add("active");
    });
  });
</script>

@endsection
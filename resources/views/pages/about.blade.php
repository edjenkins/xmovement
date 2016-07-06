@extends('layouts.app', ['bodyclasses' => 'transparent grey'])

@section('content')
    <div class="container-fluid hero-container" style="background-image:url('{{ getenv('APP_ABOUT_HEADER_IMG') }}')">
        <div class="black-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-container">
                        <h1>{{ trans('about.tagline') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<div class="container">

		<div class="row about-summary-row">

			<div class="col-md-4">
				<div class="about-summary-tile">
					<img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4KPHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCA1MTIgNTEyIiB3aWR0aD0iNTEycHgiIGhlaWdodD0iNTEycHgiPgogIDxnPgogICAgPGc+CiAgICAgIDxwYXRoIGQ9Im0yNTYsOTIuM2MtNzQuMiwwLTEyNy44LDU1LjMtMTM2LjMsMTE0LjctNS4zLDM5LjYgNy41LDc4LjIgMzQuMSwxMDcuNCAyMy40LDI1IDM2LjIsNTguNCAzNi4yLDkyLjhsLS4xLDU0LjJjMCwyMS45IDE4LjEsMzkuNiA0MC41LDM5LjZoNTIuMmMyMi40LDAgNDAuNS0xNy43IDQwLjUtMzkuNmwuMS01NC4yYzAtMzUuNCAxMS43LTY3LjggMzQuMS05MC43IDI0LjUtMjUgMzcuMy01Ny4zIDM3LjMtOTAuNy0wLjEtNzQuMS02My0xMzMuNS0xMzguNi0xMzMuNXptNDYuOCwzNjkuMWMwLDEwLjQtOC41LDE4LjgtMTkuMiwxOC44aC01Mi4yYy0xMC43LDAtMTkuMi04LjMtMTkuMi0xOC44di0yNGg5MC41djI0em0zOS42LTE1OS41Yy0yNi42LDI3LjEtNDAuNSw2NC42LTQwLjUsMTA1LjN2OS40aC05MC41di05LjRjMC0zOC42LTE2LTc3LjEtNDIuNi0xMDYuMy0yMy40LTI1LTMzLTU3LjMtMjguOC05MC43IDcuNS01MCA1NC05NyAxMTYuMS05NyA2NSwwIDExNy4yLDUxLjEgMTE3LjIsMTEyLjYgMCwyOC4xLTEwLjcsNTUuMi0zMC45LDc2LjF6IiBmaWxsPSIjNTU1NTU1Ii8+CiAgICAgIDxyZWN0IHdpZHRoPSIyMS4zIiB4PSIyNDUuMyIgeT0iMTEiIGhlaWdodD0iNTAiIGZpbGw9IiM1NTU1NTUiLz4KICAgICAgPHBvbHlnb24gcG9pbnRzPSIzODUuMSwxMDcuNCA0MDAsMTIyLjMgNDM2LjUsODcuMiA0MjEuNSw3Mi4zICAgIiBmaWxsPSIjNTU1NTU1Ii8+CiAgICAgIDxyZWN0IHdpZHRoPSI1Mi4yIiB4PSI0NDguOCIgeT0iMjM2LjIiIGhlaWdodD0iMjAuOSIgZmlsbD0iIzU1NTU1NSIvPgogICAgICA8cmVjdCB3aWR0aD0iNTIuMiIgeD0iMTEiIHk9IjIzNi4yIiBoZWlnaHQ9IjIwLjkiIGZpbGw9IiM1NTU1NTUiLz4KICAgICAgPHBvbHlnb24gcG9pbnRzPSI5MC4xLDcyLjIgNzUuMSw4Ny4xIDExMS42LDEyMi4yIDEyNi41LDEwNy4zICAgIiBmaWxsPSIjNTU1NTU1Ii8+CiAgICA8L2c+CiAgPC9nPgo8L3N2Zz4K" />
					<h3>
						{{ trans('about.summary-first-title') }}
					</h3>

					<p>
						{{ trans('about.summary-first-description') }}
					</p>
				</div>
			</div>
			<div class="col-md-4">
				<div class="about-summary-tile">
					<img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4KPHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCA1MTIgNTEyIiB3aWR0aD0iMTI4cHgiIGhlaWdodD0iMTI4cHgiPgogIDxnPgogICAgPGxpbmUgZmlsbD0iIzU1NTU1NSIgeTE9IjUwMSIgeDE9IjMwMy4xIiB5Mj0iNTAxIiB4Mj0iMzAyLjEiLz4KICAgIDxnPgogICAgICA8cGF0aCBkPSJtNTAxLDMwMC44di05MS43aC00NS4zYy01LjMtMjIuNC0xNC4zLTQzLjMtMjYuNC02Mi4xbDMyLjktMzIuNy02NC45LTY0LjYtMzMuNCwzMy4zYy0xOC44LTExLjUtMzkuNi0xOS45LTYxLjgtMjQuOHYtNDcuMmgtOTIuMXY0OC4zYy0yMiw1LjQtNDIuNiwxNC40LTYxLjEsMjYuNGwtMzQuMi0zNC02NC45LDY0LjYgMzUuMywzNS4yYy0yLjgsNC42LTUuMyw5LjItNy43LDE0LTcuNSwxNC4zLTEzLjIsMzAtMTcuMSw0NS43aC00OS4zdjkxLjdoNTAuM2MxLjUsNiAzLjMsMTEuOSA1LjMsMTcuOCAwLjEsMC40IDAuMywwLjggMC40LDEuMiAwLDAuMSAwLjEsMC4yIDAuMSwwLjQgNC45LDE0LjIgMTEuMywyNy43IDE5LjEsNDAuMmwtMzUuNSwzNS4zIDY0LjksNjQuNiAzNS4xLTM0LjljMTguMywxMS41IDM4LjYsMjAuMiA2MC4yLDI1LjR2NDguMWg5MS4xdi00Ny4xYzIyLjctNSA0NC0xMy43IDYzLjEtMjUuNmwzMi4yLDMyIDY0LjktNjQuNi0zMi4xLTMxLjljMTItMTkuMSAyMC45LTQwLjMgMjYtNjIuOWg0NC45em0tOTQuOCw2NGwyOS45LDI5LjgtMzYuNiwzNi41LTI5LjUtMjkuNGMtMjQuNywxOC45LTU0LjQsMzEuNy04Ni43LDM2djQyLjRoLTUxLjN2LTQyLjdjLTMxLjUtNC42LTYwLjQtMTcuMi04NC42LTM1LjdsLTMxLjYsMzEuNS0zNi42LTM2LjUgMzIuNC0zMS4zYy0xNy45LTI0LTMwLTUyLjQtMzQuNC04My40aC00NS4zdi01MS4xaDQ0bDEuNS0zLjZjNC43LTI5LjcgMTYuNS01Ny4xIDMzLjYtODAuM2wtMzItMzEuOSAzNi42LTM2LjUgMzEsMzEuOWMyNC0xOC41IDUyLjgtMzEuMiA4NC4xLTM2di00Mi43aDUxLjN2NDIuM2MzMiw0LjEgNjEuMywxNi40IDg2LDM0LjhsMzAuMy0zMC4xIDM1LjYsMzYuNS0yOS42LDI5LjVjMTguMiwyMy44IDMwLjcsNTIuMiAzNS41LDgzLjFoNDUuNHY1MS4xaC00NC43Yy0zLjksMzEuOC0xNi4xLDYxLjEtMzQuMyw4NS44eiIgZmlsbD0iIzU1NTU1NSIvPgogICAgICA8cGF0aCBkPSJtMjU3LDE0My40Yy02MS44LDAtMTEzLjEsNTAtMTEzLjEsMTEyLjZzNTEuNCwxMTIuNiAxMTMuMSwxMTIuNiAxMTMuMS01MS4xIDExMy4xLTExMi42LTUxLjMtMTEyLjYtMTEzLjEtMTEyLjZ6bTAsMjA0LjNjLTUxLjMsMC05Mi4xLTQwLjctOTIuMS05MS43IDAtNTEuMSA0MS45LTkxLjcgOTIuMS05MS43czkyLjEsNDAuNyA5Mi4xLDkxLjdjMC4xLDUxLjEtNDEuOCw5MS43LTkyLjEsOTEuN3oiIGZpbGw9IiM1NTU1NTUiLz4KICAgIDwvZz4KICA8L2c+Cjwvc3ZnPgo=" />
					<h3>
						{{ trans('about.summary-second-title') }}
					</h3>

					<p>
						{{ trans('about.summary-second-description') }}
					</p>
				</div>
			</div>
			<div class="col-md-4">
				<div class="about-summary-tile">
					<img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4KPHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCA1MTIgNTEyIiB3aWR0aD0iMTI4cHgiIGhlaWdodD0iMTI4cHgiPgogIDxnPgogICAgPGc+CiAgICAgIDxwYXRoIGQ9Ik02OS45LDExdjQ5MGgyNTUuNGwxMTYuOC0xMTUuN1YxMUg2OS45eiBNODkuNywzMS45aDMzMS41djMzOC44SDMyMS4xYy02LjMsMC0xMC40LDUuMi0xMC40LDEwLjR2OTloLTIyMVYzMS45eiAgICAgTTMzMS42LDQ2NS42di03NS4xaDc1LjFMMzMxLjYsNDY1LjZ6IiBmaWxsPSIjNTU1NTU1Ii8+CiAgICAgIDxyZWN0IHdpZHRoPSIyMjAiIHg9IjE0NC45IiB5PSIxMDIuNyIgaGVpZ2h0PSIyMC45IiBmaWxsPSIjNTU1NTU1Ii8+CiAgICAgIDxyZWN0IHdpZHRoPSIyMjAiIHg9IjE0NC45IiB5PSIxOTEuNCIgaGVpZ2h0PSIyMC45IiBmaWxsPSIjNTU1NTU1Ii8+CiAgICAgIDxyZWN0IHdpZHRoPSIyMjAiIHg9IjE0NC45IiB5PSIyODAiIGhlaWdodD0iMjAuOSIgZmlsbD0iIzU1NTU1NSIvPgogICAgPC9nPgogIDwvZz4KPC9zdmc+Cg==" />
					<h3>
						{{ trans('about.summary-third-title') }}
					</h3>

					<p>
						{{ trans('about.summary-third-description') }}
					</p>
				</div>
			</div>

		</div>

		<div class="row about-phase-row">

			<div class="col-md-12">

				<h3 class="about-phase-title">{{ trans('about.about-phase-title') }}</h3>

				<div class="about-phase-tile">

					<div class="phase-step-indicator">
						1
					</div>

					<h3>
						{{ trans('about.phase-first-title') }}
					</h3>

					<p>
						{{ trans('about.phase-first-description') }}
					</p>

					<br />

					<p>
						{{ trans('about.phase-first-detail') }}
					</p>
				</div>

				<div class="about-phase-tile">

					<div class="phase-step-indicator">
						2
					</div>

					<h3>
						{{ trans('about.phase-second-title') }}
					</h3>

					<p>
						{{ trans('about.phase-second-description') }}
					</p>

					<br />

					<p>
						{{ trans('about.phase-second-detail') }}
					</p>
				</div>

				<div class="about-phase-tile">

					<div class="phase-step-indicator">
						3
					</div>

					<h3>
						{{ trans('about.phase-third-title') }}
					</h3>

					<p>
						{{ trans('about.phase-third-description') }}
					</p>

					<br />

					<p>
						{{ trans('about.phase-third-detail') }}
					</p>
				</div>

			</div>
		</div>

	</div>
@endsection

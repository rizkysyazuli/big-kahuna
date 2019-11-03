@extends('layout')

@section('content')

    <bkpagetree inline-template v-cloak :menu="'{{ $menu }}'" :locale="'{{ $locale }}'">

        <div id="bigkahuna">

            <div id="page-tree">

                <div class="flex items-center flex-wrap mb-3">

                    <h1 class="w-full text-center mb-2 md:mb-0 md:text-left md:w-auto md:flex-1">{{ $menu }} <small class="text-muted">({{ $locale }})</small></h1>

                    <div class="controls flex flex-wrap justify-center md:block items-center w-full md:w-auto">
                        <div class="btn-group btn-group-primary ml-1" v-if="arePages && changed">
                            <button type="button" class="btn btn-primary" v-if="! saving" @click="save">
                                Save Changes
                            </button>
                            <span class="btn btn-primary btn-has-icon-right disabled" v-if="saving">
                                Saving <i class="icon icon-circular-graph animation-spin"></i>
                            </span>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-5">

                        <bkfilter v-bind:locale="locale"></bkfilter>

                        <bkcustomlink></bkcustomlink>

                    </div>

                    <div class="col-md-7">

                        <div class="page-tree">

                            <div :class="{'page-tree': true, 'show-urls': showUrls}">

                                <div class="loading" v-if="loading">
                                    <span class="icon icon-circular-graph animation-spin"></span> Loading
                                </div>

                                <div class="saving" v-if="saving">
                                    <div class="inner">
                                        <i class="icon icon-circular-graph animation-spin"></i> Saving
                                    </div>
                                </div>

                                {{-- Keeping this or else drag & drop won't work --}}
                                <ul class="tree-home list-unstyled" v-if="!loading">
                                </ul>
                                <bkbranches
                                    :pages="pages"
                                    :depth="1"
                                    :sortable="isSortable"
                                    :dirty="!dirty">
                                </bkbranches>

                                <div class="card" v-if="!arePages">
                                    <div class="no-results">
                                        <svg width="254" height="234" viewBox="0 0 254 234" xmlns="http://www.w3.org/2000/svg"><g fill="#FFF" stroke="#CED4DA" stroke-width="3" fill-rule="evenodd"><path d="M13.59 174.1c3.14 15.28 10.54 26.27 22.21 32.97 17.5 10.05 35.97 17.83 45.16 19.46 9.18 1.62 39.73 7.43 58.96 5.26 19.23-2.18 42.76-5.58 55.03-10.5 8.19-3.28 19.92-10.24 35.2-20.87L106.3 159.77 13.59 174.1z"/><path d="M17.01 148.74c-1.78 3.87-3.5 6.82-5.17 8.86-2.5 3.04-6.7 6.75-7.73 9.66-1.02 2.91-3.22 7.64 0 9.61 3.23 1.98 7.18 1.53 10.35 1.75 3.17.23 6.33-2.13 5.39 1.17-.95 3.3-1 4.56-3.4 5.91-2.38 1.35-3.25 2.2-3.25 3.93s1.3 3.68 3.25 1.84 2.98-4.6 5.65-4.13c2.67.48 3.2.55 3.88 2.57.67 2.02-.81 3.48 2.2 2.34 3-1.15 4.43-3.13 6.25-.78 1.82 2.34 3.91 9.13 6.57 6.03 2.66-3.1 2.74-7.26 3.93-8.5 1.19-1.25 5.06-3.94 5.78-1.19.73 2.74-.57 8.85.36 10.73.93 1.88 2.68 3.93 5.37 3.93s5.05-1.2 6.44.79c1.4 2-.33 3.92 1.58 5.19 1.9 1.27 3.13.3 6.74-.54 3.6-.84 7.92-.42 8.73 1.57.8 1.99 1.38 5.94 3.66 7.13 2.3 1.19 4.77 3.4 7.48.58 2.7-2.82 5.12-4.1 5.12-6.83 0-2.73 1.05-6.7 2.94-3.63 1.9 3.07 3.04 10.06 6.05 12.48 3.01 2.41 4.14 6.3 8.84 3.35 4.7-2.94 7.11-4.15 7.45-7.8.33-3.65-1.95-7.88 2-6.85 3.93 1.04 4.65 5.69 7.68 4.24 3.03-1.45 4.5-4.03 7.83-3.35 3.34.68 3.4 3.73 2.14 5.16-1.26 1.43-3.01 5.28-2.14 6.94.88 1.66 3.7 5.38 8.96 4.76 5.25-.62 9.45-1.04 10.06-5.05.6-4-1.67-10.77.74-13.54 2.41-2.77 4.61-5.46 6.1-3.81 1.47 1.65 1.5 3.35 0 5.54-1.52 2.18-3.54 6.37-2 8.39 1.53 2.02 5.85 2.43 7.2 0 1.34-2.43 2.29-5.67 4.06-4.45 1.76 1.22 1.84 6.88 5.2 4.45 3.36-2.43 3.71-7.19 3.36-8.4-.34-1.2-.3-5.59 1.24-6.98 1.53-1.4 4.24-4.3 5.06-2.69.81 1.62.26 7.57.54 8.8.27 1.22.03 2.74 2 1.98 1.96-.76 2.44-1.55 3.64-.78 1.2.78 4.74 8 7.4 4.84 2.64-3.15 1.1-7.64 5.13-8.27 4.01-.63 6.03.36 6.46-1.96.43-2.31-2.07-5.02 1.4-4.6 3.45.4 10.1 2.82 12.07 4.13 1.97 1.31 3.84 3.78 5.32 1.64 1.48-2.15 2.24-2.85 1.3-6.36-.95-3.52-1.61-6.3 0-6.3 1.6 0 6.08 1.7 7.3-.77 1.2-2.47.13-4-1.28-7.55-1.42-3.55-3.5-4.34-.33-6.3 3.18-1.95 3.54-1.5 6.59-.75 3.05.76 5.2 0 5.2-2.67 0-2.66.56-7.5-2.97-9.25-3.54-1.75-6.44-2.16-6.83-3.24-.26-.72-1.16-1.8-2.71-3.23L66.43 169.85l-49.42-21.1z"/><path d="M243.77 143.92c-.49 12.7-5.59 22.33-15.31 28.88-14.58 9.83-64.53 31.65-107.07 26.97-28.35-3.13-25.7-12.33 7.94-27.6l78.82-25.55 35.62-2.7z"/><path d="M13.59 137.83s-3.43 19.2 10.1 31.15c13.55 11.95 54.96 27.49 81.49 29.45 17.69 1.3 18.85-8.8 3.49-30.3L62.4 140.08l-47.72-7.06-1.1 4.81zM236.1 133.02c6.98 2.34 11.27 4.48 12.87 6.4a11.74 11.74 0 0 1 2.73 6.6c-.27 1.27-1.63 1.7-4.1 1.3-2.46-.42-6.02.43-10.66 2.55a49.95 49.95 0 0 1-9.36 2.53c-2.64.39-1.74-3.94 2.7-12.98l5.82-6.4z"/><path d="M19.7 124.32c-5.26 3.05-8.71 6-10.35 8.87a31.71 31.71 0 0 0-3.29 7.38c-.63 2.31.46 2.89 3.29 1.73 4.24-1.73 10.3-2.79 15.85-1.73 3.7.7 4.79-2.94 3.28-10.93l-8.78-5.32zM46.94 150.98c15.29 9.06 26.4 16.97 33.31 23.73 10.38 10.15 19.82 18.57 22.37 23.19 2.56 4.62 4.43 13.05 14.39 7.14 9.96-5.9 22.16-15.68 29.93-20.08 7.78-4.4 21.46-13.36 30.74-15.79 6.2-1.61 6.61-3.1 1.27-4.47l-71.76-20.78-60.25 7.06z"/><path d="M107.19 148.74c6.08 5.54 11.5 9.54 16.27 12a99.29 99.29 0 0 0 22.2 8.24c5.03 1.22 13.2 2.01 24.54 2.4 12.3.64 23.82-.55 34.55-3.59 16.1-4.55 23.32-10.8 26.7-14.21 3.4-3.41 6.57-8.92 6.57-12.34v-12.76l-124.47 12.76-6.36 7.5z"/><path d="M117 146.02c5.69 4.64 13.44 7.98 23.26 10.01 14.72 3.06 38.94 4.95 52.41 2.86 13.48-2.1 27.98-7.64 32.2-9.95 4.23-2.3 9.21-6.85 10.33-9.52 1.11-2.68 5.13-6.78 1-19.97-2.75-8.8-39.9-2.94-111.42 17.54l-7.77 9.03z"/><path d="M129.58 139.42c-7.47 6.67-16.69 11.16-27.66 13.47-16.46 3.47-35.02 3.13-38.35 3.13-3.33 0-21.83-2.87-32.23-8.3-6.93-3.61-11.62-8.97-14.08-16.08l-.8-12.19 114.16 17.04-1.04 2.93z"/><path d="M19.35 109.67c-4.52 8.02-3.75 15.12 2.33 21.3 9.1 9.28 27.45 14.08 42.7 14.92 15.25.84 38.85-2.4 51.47-8.65 8.42-4.18 9.86-10.02 4.3-17.54l-100.8-10.03zM174.48 135.91c2.48 3.04 4.7 4.82 6.68 5.36 2.96.8 4.46-.8 10.14 0 5.67.8 9.35 1.85 11.9 0 2.55-1.85 2.84-2.47 5.99-2.16 3.14.3 4.93-2.96 7.4-3.87 2.47-.9 4 .27 7.25-1.3 3.26-1.57 1.14-4.41 4.34-5.46 3.2-1.05 7.03.32 8.09-3.48 1.06-3.8-.15-4.52 2.58-5.4 2.74-.9 3.63-1.09 3.63-4.63s3.81-5.59 2.4-9.74c-.95-2.76-3.5-6.26-7.68-10.48l-65.82 27.2 3.1 13.96z"/><path d="M37.97 119.13c-.31 2.86.7 4.86 3.05 6 3.51 1.7 5.23.14 7.7 3.35 2.47 3.2 2.49 7.72 8.83 7.72s8.06.22 10.71 1.38c2.66 1.15 6.07 2.64 9.36 1.32 3.3-1.32 5.2 0 7.42 0 2.22 0 3.09-2.7 5.82-2.7 2.73 0 4.5 1.73 7.01 0 2.51-1.72 1.77-3.51 5.38-3.51 2.42 0 4.68-.5 6.79-1.5l-4.84-9.61-64.18-12.6-3.05 10.15z"/><path d="M103.25 124.32c.53 8.43 7.7 14.2 21.54 17.3 20.76 4.65 39.95 1.55 50.77-3.12a38.06 38.06 0 0 0 17.11-14.18v-9.35l-89.42 9.35zM16.22 89l-2.6 11.5c-.33 5.6 2.47 10.1 8.4 13.46 8.89 5.06 18.37 8.84 38.31 10.08 13.3.83 22.27-.21 26.93-3.11L16.22 88.99z"/><path d="M131.1 2.22c-34.81 0-53.26 1.8-76.4 12.05-23.13 10.25-32.28 17.54-40.02 35.69C6.95 68.1 7.43 84.5 17.4 95.79c9.97 11.28 16.25 16.24 52.44 25.81 24.13 6.38 52.21 8.32 84.25 5.82 28.3-3.4 50.82-9.35 67.59-17.88 16.76-8.52 25.4-20.52 25.92-35.98 0-13.1-6.19-27.02-18.56-41.75-18.56-22.1-62.9-28.12-97.94-29.6z"/><path d="M108.02 48.86c.24-7.23-1.19-10.02-4.28-8.39-3.09 1.63-1.66 4.43 4.28 8.4zM130.29 34.24c-5.69 4.47-6.92 7.36-3.68 8.67 3.24 1.32 4.46-1.57 3.68-8.67zM131.88 70.3c1.49-7.08.57-10.08-2.76-9.01-3.32 1.07-2.4 4.07 2.76 9z" stroke-linecap="round"/><path d="M163.23 68.53c-3.41-6.38-6.05-8.09-7.9-5.13-1.86 2.96.77 4.67 7.9 5.13z"/><path d="M155.57 36.97c-3.82 6.14-3.98 9.28-.49 9.4 3.5.14 3.66-3 .5-9.4zM180.72 58.6c6.31-3.51 7.98-6.17 4.99-7.98-3-1.8-4.66.86-5 7.99zM180.66 29.4c2.25 6.87 4.55 9 6.9 6.42 2.34-2.6.04-4.73-6.9-6.42zM165.96 24.42c2.69-6.7 2.3-9.82-1.15-9.35-3.47.48-3.08 3.6 1.15 9.35zM134.46 17.48c5.39 4.83 8.45 5.53 9.18 2.11.74-3.41-2.32-4.12-9.18-2.11zM74.2 28.88c7.15-1.02 9.66-2.9 7.52-5.67-2.15-2.75-4.66-.86-7.52 5.67zM45.22 28.9c2.86-6.54 5.37-8.43 7.52-5.67 2.14 2.76-.37 4.65-7.52 5.67zM37.16 46.62c-4.93 5.17-7.93 6.08-9 2.76-1.08-3.33 1.93-4.25 9-2.76zM51.76 47.61c-2.7 6.7-2.3 9.83 1.15 9.35 3.46-.48 3.08-3.6-1.15-9.35zM72.88 67.8c6.14 3.82 9.27 3.99 9.4.5.13-3.5-3-3.66-9.4-.5zM108.57 75.17c-2.25-6.87-4.54-9.01-6.89-6.42-2.34 2.59-.04 4.73 6.9 6.42zM78.3 44.62c2.26 6.87 4.55 9.01 6.9 6.42 2.34-2.6.04-4.73-6.9-6.42zM108.9 10.6c-1.5 7.07-.57 10.08 2.75 9 3.33-1.07 2.4-4.07-2.75-9zM220.46 31.11c-7.2.52-9.84 2.23-7.9 5.14 1.95 2.9 4.59 1.19 7.9-5.14zM213.76 52.31c-5.86-4.23-8.97-4.62-9.35-1.14-.37 3.47 2.75 3.85 9.35 1.14zM212.72 74.15c-3.27 6.45-3.16 9.58.33 9.4 3.5-.17 3.38-3.3-.33-9.4zM228.48 63.74c5.7 4.44 8.8 4.93 9.3 1.47s-2.6-3.95-9.3-1.47zM190.13 71.3c-5.69 4.46-6.91 7.35-3.68 8.66 3.24 1.32 4.46-1.57 3.68-8.67z" stroke-linecap="round"/></g></svg>
                                        <h2>There's nothing on the menu yet</h2>
                                        <p class="text-muted">Add items from the content list or add a custom link.</p>
                                    </div>
                                </div>

                            </div>

                            <audio v-el:click>
                                <source src="/index.php/_resources/cp/audio/click.mp3" type="audio/mp3">
                            </audio>
                            <audio v-el:card_drop>
                                <source src="/index.php/_resources/cp/audio/card_drop.mp3" type="audio/mp3">
                            </audio>
                            <audio v-el:card_set>
                                <source src="/index.php/_resources/cp/audio/card_set.mp3" type="audio/mp3">
                            </audio>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </bkpagetree>

@endsection

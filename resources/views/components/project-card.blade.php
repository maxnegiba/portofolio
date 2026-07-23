@props(['project'])

@php
    $canGenerateProjectUrl = false;
    try {
        $url = route('project', $project);
        $canGenerateProjectUrl = true;
    } catch (\Exception $e) {
        $canGenerateProjectUrl = false;
    }
@endphp

<div class="bg-zinc-900 border border-white/10 rounded-2xl overflow-hidden hover:border-purple-500/50 transition-all duration-500 group flex flex-col h-full hover:shadow-[0_0_30px_rgba(168,85,247,0.15)] animate-fade-in-up">
    <div class="relative h-64 overflow-hidden bg-black/50">
        <div class="absolute inset-0 bg-gradient-to-t from-zinc-900 via-zinc-900/20 to-transparent z-10"></div>
        @if($project->thumbnail_url)
            <x-responsive-image :path="$project->thumbnail_url" :alt="$project->getLocalizedTitle()" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-in-out" />
        @else
            <div class="w-full h-full flex items-center justify-center text-white/20">
                <i class="fas fa-image text-4xl"></i>
            </div>
        @endif
        
        <div class="absolute top-4 left-4 z-20">
            <span class="px-3 py-1 bg-black/50 backdrop-blur-md border border-white/10 rounded-full text-xs font-medium text-white/80">
                {{ $project->category === 'automation' ? 'Workflow Automation' : 'Enterprise Web App' }}
            </span>
        </div>
    </div>
    
    <div class="p-8 flex flex-col flex-1 relative z-20">
        <h3 class="text-2xl font-bold text-white mb-3 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-purple-400 group-hover:to-cyan-400 transition-all duration-300">
            {{ $project->getLocalizedTitle() }}
        </h3>
        <p class="text-gray-400 mb-6 line-clamp-3 leading-relaxed">
            {{ $project->getLocalizedDescription() }}
        </p>
        
        @if($project->tech && count($project->tech) > 0)
            <div class="flex flex-wrap gap-2 mb-8">
                @foreach(array_slice($project->tech, 0, 4) as $tech)
                    <span class="px-3 py-1 bg-white/5 border border-white/10 rounded-lg text-xs font-medium text-white/70 group-hover:border-white/20 transition-colors">
                        {{ $tech }}
                    </span>
                @endforeach
                @if(count($project->tech) > 4)
                    <span class="px-3 py-1 bg-white/5 border border-white/10 rounded-lg text-xs font-medium text-white/50">
                        +{{ count($project->tech) - 4 }}
                    </span>
                @endif
            </div>
        @endif
        
        <div class="flex items-center gap-4 mt-auto pt-6 border-t border-white/5">
            @if($canGenerateProjectUrl)
                <a href="{{ route('project', $project) }}" class="flex-1 text-center py-3 px-6 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-white/20 rounded-xl text-white font-medium transition-all duration-300">
                    Read Case Study
                </a>
            @endif
            @if($project->live_url)
                <a href="{{ $project->live_url }}" target="_blank" class="w-12 h-12 flex items-center justify-center bg-white/5 hover:bg-white/10 border border-white/10 hover:border-white/20 rounded-xl text-white/70 hover:text-white transition-all duration-300 group/link">
                    <i class="fas fa-external-link-alt group-hover/link:-translate-y-0.5 group-hover/link:translate-x-0.5 transition-transform"></i>
                </a>
            @endif
        </div>
    </div>
</div>
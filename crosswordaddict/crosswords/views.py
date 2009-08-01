# Create your views here.
from crosswordaddict.crosswords.models import CsPresets, CsClues, CsCrossword
from django.shortcuts import render_to_response
from django.http import HttpResponse

def index(request):
    if request.GET:
        if 'grid_id' in request.GET:
            grid_id = request.GET['grid_id']
            grid = CsPresets.objects.filter(id=grid_id)[0].grid
            crossword_id = CsCrossword.objects.filter(gridid=grid_id)[0].id
            clues = CsClues.objects.filter(crosswordid=crossword_id)
            clue_dict = [(x.code, x.clue) for x in clues]
            print clue_dict[0]
            return render_to_response('crossword.html', {'grid':grid})
        else:
            return render_to_response('crossword.html', {'error':True})

    return render_to_response('index.html')


def crossword(request):
    pass


def crossword_index(request):
    pass

    
def crossword_category(request):
    pass

# Create your views here.
from crosswordaddict.crosswords.models import CsPresets, CsClues, CsCrossword
from django.shortcuts import render_to_response
from django.http import HttpResponse
from django.core import serializers

def index(request):
    if request.GET:
        if 'grid_id' in request.GET:
            grid_id = request.GET['grid_id']
            grid = CsPresets.objects.filter(id=grid_id)[0].grid
            crossword_id = CsCrossword.objects.filter(gridid=grid_id).values_list('id')
            cs_clues = CsClues.objects.filter(crosswordid=crossword_id).values_list('square', 'code', 'clue')
            print cs_clues
            number_info = dict([(int(x[0]), {"code":x[1][:-1]}) for x in cs_clues])
            across = [({"square":int(x[0]), "code":x[1][:-1], "clue":x[2]}) for x in cs_clues if x[1][-1]=='A']
            down = [({"square":int(x[0]), "code":x[1][:-1], "clue":x[2]}) for x in cs_clues if x[1][-1]=='D']           
            print across
            print down
            crossword = []
            for i,j in enumerate(grid):
                if i+1 in number_info.keys():
                    crossword.append({'grid':j, 'code': number_info[i+1]['code']})
                else:
                    crossword.append({'grid':j, 'code': ''})
                    
            #print crossword
            return render_to_response('crossword.html', {'crossword':crossword, 'across': across, 'down':down})
        else:
            return render_to_response('crossword.html', {'error':True})

    return render_to_response('index.html')


def crossword(request):
    pass


def crossword_index(request):
    pass

    
def crossword_category(request):
    pass

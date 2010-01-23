# Create your views here.
from crosswordaddict.crosswords.models import CsPresets, CsClues, CsCrossword
from django.shortcuts import render_to_response
from django.http import HttpResponse
from django.core import serializers
from django.utils.datastructures import MultiValueDictKeyError

def index(request):
    if request.GET:
        if 'grid_id' in request.GET:
            grid_id = request.GET['grid_id']
            grid = CsPresets.objects.filter(id=grid_id)[0].grid
            answers = CsPresets.objects.filter(id=grid_id)[0].answers
            crossword_id = CsCrossword.objects.filter(gridid=grid_id).values_list('id')
            cs_clues = CsClues.objects.filter(crosswordid=crossword_id).values_list('square', 'code', 'clue')
            #print cs_clues
            number_info = dict([(int(x[0]), {"code":x[1][:-1]}) for x in cs_clues])
            across = [({"square":int(x[0]), "code":x[1][:-1], "clue":x[2]}) for x in cs_clues if x[1][-1]=='A']
            down = [({"square":int(x[0]), "code":x[1][:-1], "clue":x[2]}) for x in cs_clues if x[1][-1]=='D']           
            #print across
            #print down
            print answers
            crossword = []
            for i,j in enumerate(grid):
                try:
                    ans = answers[i]
                except IndexError:
                    ans = ''
                print i, ans
                if i+1 in number_info.keys():
                    crossword.append({'grid':j, 'code': number_info[i+1]['code'], 'ans': ans})
                else:
                    crossword.append({'grid':j, 'code': '', 'ans': ans})                    
            # print crossword
            return render_to_response('crossword.html', {'crossword':crossword, 'across': across, 'down':down, 'grid_id': grid_id})
        else:
            return render_to_response('crossword.html', {'error':True})

    return render_to_response('index.html')


def crossword(request):
    pass


def crossword_index(request):
    if request.GET:
        if 'grid_id' in request.GET:
            grid_id = request.GET['grid_id']
            grid = CsPresets.objects.get(id=grid_id)
            ans = []
            for i in range(1,225):
                try:
                    ans.append(request.GET[str(i)])
                except MultiValueDictKeyError:
                    ans.append(' ')

            for i,j in enumerate(ans):
                print i+1, j
            
            grid.answers = ''.join(ans)
            print grid.answers
            grid.save()
            return render_to_response('index.html')
        else:
            return render_to_response('crossword.html', {'error':True})

    return render_to_response('index.html')


    
def crossword_category(request):
    pass

# Create your views here.
import math
from datetime import date
from .models import CsPresets, CsClues, CsCrossword
from django.shortcuts import render_to_response, redirect
from django.shortcuts import get_object_or_404
from django.http import HttpResponse
from django.core import serializers
from django.utils.datastructures import MultiValueDictKeyError
from django.utils import simplejson
from django.contrib.auth.models import User

from utils import get_clues
from forms import CrosswordForm
from favorites.models import Favorite


def index(request):
    return render_to_response('index.html')

def crossword(request, id):
    cspreset = get_object_or_404(CsPresets, pk=id)
    grid = cspreset.grid
    answers = cspreset.answers
    crossword_id = CsCrossword.objects.get(gridid=id).id
    cs_clues = CsClues.objects.filter(crosswordid=crossword_id)
    size = int(math.sqrt(len(grid)))
    u = User.objects.get(username='badri')
    number_info = dict([(int(x.square), {"code":x.code[:-1]}) for x in cs_clues])
    across = [({"square":int(x.square), "code":x.code[:-1], "clue":x.clue, "note":x.notes, "favorite": Favorite.objects.favorites_for_object(x,u).exists() }) for x in cs_clues if x.code[-1]=='A']
    down = [({"square":int(x.square), "code":x.code[:-1], "clue":x.clue, "note":x.notes, "favorite": Favorite.objects.favorites_for_object(x,u).exists()}) for x in cs_clues if x.code[-1]=='D']
    crossword = []
    for i,j in enumerate(grid):
        try:
            ans = answers[i]
        except IndexError:
            ans = ''
        if i+1 in number_info.keys():
            crossword.append({'grid':j, 'code': number_info[i+1]['code'], 'ans': ans})
        else:
            crossword.append({'grid':j, 'code': '', 'ans': ans})
    return render_to_response('crossword.html', {'crossword':crossword, 'across': across, 'down':down, 'grid_id': id, 'crossword_id': crossword_id, 'name': cspreset.name, 'appeared': cspreset.appeared, 'size': size, 'gridlen': len(grid)})

def crossword2(request, id):
    cspreset = get_object_or_404(CsPresets, pk=id)
    grid = cspreset.grid
    answers = cspreset.answers
    crossword_id = CsCrossword.objects.get(gridid=id).id
    cs_clues = CsClues.objects.filter(crosswordid=crossword_id)
    orientation = {'D': 'down', 'A': 'across'}
    puzzle_data = [{"clue": x.clue, "answer": x.answer, "startx": x.square%15, "starty": x.square/15 + 1, "orientation": orientation[x.code[-1]] } for x in cs_clues]
    return render_to_response('crossword2.html', {'name': cspreset.name, 'appeared': cspreset.appeared, 'puzzle_data': simplejson.dumps(puzzle_data)})


def list_crosswords(request):
    xwords = []
    xwords_data = CsPresets.objects.all()
    return render_to_response('crossword_list.html', {'xwords': xwords_data})

def crossword_save(request):
    if request.is_ajax():
        if 'grid_id' in request.POST:
            grid_id = request.POST['grid_id']
            grid = CsPresets.objects.get(id=grid_id)
            ans = []
            for i in range(1,226):
                try:
                    if not request.POST[str(i)]:
                        ans.append(' ')
                    else:
                        ans.append(request.POST[str(i)])
                except MultiValueDictKeyError:
                    ans.append(' ')

            grid.answers = ''.join(ans)
            grid.save()
            response = {'message' : 'Crossword saved successfully.'}
            data = simplejson.dumps(response)
            return HttpResponse(data, mimetype='application/json')
        else:
            response = {'message' : 'There was an error in saving the crossword.'}
            data = simplejson.dumps(response)
            return HttpResponse(data, mimetype='application/json')


    
def crossword_category(request):
    pass

def crossword_detail(request):
    pass

def create(request, size=15):
    if request.method == 'POST':
        xword = request.POST
        if xword['across'] and xword['down']:
            across_clues = get_clues(xword, 'A')
            down_clues = get_clues(xword, 'D')
            clues = across_clues + down_clues
        else:            
            clues = []
            for k,v in xword.iteritems():
                if '_A#' in k:
                    clue_num = k[:-3]
                    clue_text = xword[clue_num+'_A']
                    answer = xword[clue_num+'_AA']
                    answer_length = xword[clue_num+'_A_']
                    grid_number = xword[clue_num+'_A_N']
                    clues.append({'clue':clue_text, 'answer':answer, 'square':grid_number, 'code':clue_num+'A'})
                if '_D#' in k:
                    clue_num = k[:-3]
                    clue_text = xword[clue_num+'_D']
                    answer = xword[clue_num+'_DA']
                    answer_length = xword[clue_num+'_D_']
                    grid_number = xword[clue_num+'_D_N']
                    clues.append({'clue':clue_text, 'answer':answer, 'square':grid_number, 'code':clue_num+'D'})                
        # do some kind of error checking down here.
        grid = CsPresets(grid=xword['grid'], name=xword['name'], description=xword['description'], appeared=xword['appeared'])
        grid.save()
        crossword = CsCrossword(gridid=grid.id, dateadded=date.today(), user='bar')
        crossword.save()
        for c in clues:
            clue = CsClues(crosswordid=crossword.id, clue=c['clue'], answer=c['answer'], square=c['square'], code=c['code'])
            clue.save()
        response = simplejson.dumps({'success':'False', 'html':'<span> abc </span>'})
        return HttpResponse(response, mimetype="application/json")
    else:
        xwd_form = CrosswordForm()
        return render_to_response('create.html', {'xword': xwd_form, 'size': size})

def crossword_add_note(request):
    if request.is_ajax():
        resp = request.POST
        clue = CsClues.objects.get(crosswordid=resp['crossword'], code=resp['clue'])
        clue.notes = resp['note']
        clue.save()
        response = {'clue' : resp['clue'], 'note': resp['note']}
        data = simplejson.dumps(response)
        return HttpResponse(data, mimetype='application/json')

def clue_add_favorite(request):
    if request.is_ajax():
        resp = request.POST
        clue = CsClues.objects.get(crosswordid=resp['crossword'], code=resp['clue'])
        user = User.objects.get(username='badri')
        Favorite.objects.create_favorite(clue, user)
        response = {'clue' : resp['clue']}
        data = simplejson.dumps(response)
        return HttpResponse(data, mimetype='application/json')

def clue_reveal_answer(request):
    if request.is_ajax():
        resp = request.POST
        clue = CsClues.objects.get(crosswordid=resp['crossword'], code=resp['clue'])
        response = {'answer' : clue.answer}
        data = simplejson.dumps(response)
        return HttpResponse(data, mimetype='application/json')

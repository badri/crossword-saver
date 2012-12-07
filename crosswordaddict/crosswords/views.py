# Create your views here.
from datetime import date
from crosswordaddict.crosswords.models import CsPresets, CsClues, CsCrossword
from django.shortcuts import render_to_response, redirect
from django.shortcuts import get_object_or_404
from django.http import HttpResponse
from django.core import serializers
from django.utils.datastructures import MultiValueDictKeyError
from django.utils import simplejson

from utils import get_clues

def index(request):
    return render_to_response('index.html')

def crossword(request, id):
    cspreset = get_object_or_404(CsPresets, pk=id)
    grid = cspreset.grid
    answers = cspreset.answers
    crossword_id = CsCrossword.objects.filter(gridid=id).values_list('id')
    cs_clues = CsClues.objects.filter(crosswordid=crossword_id).values_list('square', 'code', 'clue')
    #print cs_clues
    number_info = dict([(int(x[0]), {"code":x[1][:-1]}) for x in cs_clues])
    across = [({"square":int(x[0]), "code":x[1][:-1], "clue":x[2]}) for x in cs_clues if x[1][-1]=='A']
    down = [({"square":int(x[0]), "code":x[1][:-1], "clue":x[2]}) for x in cs_clues if x[1][-1]=='D']           
    #print across
    #print down
    #print answers
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
    #print crossword
    return render_to_response('crossword.html', {'crossword':crossword, 'across': across, 'down':down, 'grid_id': id})


def list_crosswords(request):
    xwords = []
    xwords_data = CsPresets.objects.all()
    return render_to_response('crossword_list.html', {'xwords': xwords_data})

def crossword_save(request):
    if request.POST:
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
            #print grid.answers
            grid.save()
            return redirect('home')
        else:
            return render_to_response('crossword.html', {'error':True})

    return render_to_response('index.html')


    
def crossword_category(request):
    pass

def crossword_detail(request):
    pass

def create(request):
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
                    print '%s %s,%s' % (clue_num, clue_text, grid_number)
                    clues.append({'clue':clue_text, 'answer':answer, 'square':grid_number, 'code':clue_num+'A'})
                if '_D#' in k:
                    clue_num = k[:-3]
                    clue_text = xword[clue_num+'_D']
                    answer = xword[clue_num+'_DA']
                    answer_length = xword[clue_num+'_D_']
                    grid_number = xword[clue_num+'_D_N']
                    print '%s %s,%s' % (clue_num, clue_text, grid_number)
                    clues.append({'clue':clue_text, 'answer':answer, 'square':grid_number, 'code':clue_num+'D'})
                
        #print xword['grid']
        #print clues
        # do some kind of error checking down here.
        grid = CsPresets(grid=xword['grid'], name=xword['name'], description=xword['description'])
        grid.save()
        crossword = CsCrossword(gridid=grid.id, dateadded=date.today(), user='bar')
        crossword.save()
        for c in clues:
            clue = CsClues(crosswordid=crossword.id, clue=c['clue'], answer=c['answer'], square=c['square'], code=c['code'])
            print clue
            clue.save()
        response = simplejson.dumps({'success':'False', 'html':'<span> abc </span>'})
        return HttpResponse(response, mimetype="application/json")
    else:
        return render_to_response('create.html')


from django.db import models
from widgets import CrosswordWidget
from django.contrib.admin.widgets import AdminIntegerFieldWidget

# The following code is based on tagging autocomplete code by Jannis Leidel

class CrosswordField(models.IntegerField):
    """
    Crossword field with custom widget
    """

    def formfield(self, **kwargs):
        defaults = {'widget': CrosswordWidget}
        defaults.update(kwargs)

        # As an ugly hack, we override the admin widget
        if defaults['widget'] == AdminIntegerFieldWidget:
            defaults['widget'] = CrosswordWidget

        return super(CrosswordField, self).formfield(**defaults)

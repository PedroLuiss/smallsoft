import appsAndPages from './apps-and-pages'
import charts from './charts'
import dashboard from './dashboard'
import forms from './forms'
import others from './others'
import uiElements from './ui-elements'

import small from './small-router'

export default [...small,...dashboard, ...appsAndPages, ...uiElements, ...forms, ...charts, ...others]

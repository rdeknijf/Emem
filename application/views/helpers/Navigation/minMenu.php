<?php
/**
 * Standard Navigation menu, but without all those anoying spaces and newlines
 * Who the fuck thought that was smart for a production site!
 *
 * Add this: resources.view.helperPath.myApp_View_Helper_Navigation = APPLICATION_PATH "/views/helpers/Navigation"
 * ...to the bootstrap, with this file as /views/helpers/Navigation/minMenu.php
 * 
 * @author Rutger de Knijf
 */
class Emem_View_Helper_Navigation_MinMenu extends Zend_View_Helper_Navigation_Menu {
    
    public function minMenu(Zend_Navigation_Container $container = null) {
        
        if (null !== $container) {
            $this->setContainer($container);
        }
        return $this;        
        
    }
    /**
     * Renders a normal menu (called from {@link renderMenu()})
     *
     * @param  Zend_Navigation_Container $container   container to render
     * @param  string                    $ulClass     CSS class for first UL
     * @param  string                    $indent      initial indentation
     * @param  int|null                  $minDepth    minimum depth
     * @param  int|null                  $maxDepth    maximum depth
     * @param  bool                      $onlyActive  render only active branch?
     * @return string
     */
    protected function _renderMenu(Zend_Navigation_Container $container,
                                   $ulClass,
                                   $indent,
                                   $minDepth,
                                   $maxDepth,
                                   $onlyActive)
    {
        
        $indent = '';        
        
        $html = '';

        // find deepest active
        if ($found = $this->findActive($container, $minDepth, $maxDepth)) {
            $foundPage = $found['page'];
            $foundDepth = $found['depth'];
        } else {
            $foundPage = null;
        }

        // create iterator
        $iterator = new RecursiveIteratorIterator($container,
                            RecursiveIteratorIterator::SELF_FIRST);
        if (is_int($maxDepth)) {
            $iterator->setMaxDepth($maxDepth);
        }

        // iterate container
        $prevDepth = -1;
        foreach ($iterator as $page) {
            $depth = $iterator->getDepth();
            $isActive = $page->isActive(true);
            if ($depth < $minDepth || !$this->accept($page)) {
                // page is below minDepth or not accepted by acl/visibilty
                continue;
            } else if ($onlyActive && !$isActive) {
                // page is not active itself, but might be in the active branch
                $accept = false;
                if ($foundPage) {
                    if ($foundPage->hasPage($page)) {
                        // accept if page is a direct child of the active page
                        $accept = true;
                    } else if ($foundPage->getParent()->hasPage($page)) {
                        // page is a sibling of the active page...
                        if (!$foundPage->hasPages() ||
                            is_int($maxDepth) && $foundDepth + 1 > $maxDepth) {
                            // accept if active page has no children, or the
                            // children are too deep to be rendered
                            $accept = true;
                        }
                    }
                }

                if (!$accept) {
                    continue;
                }
            }

            // make sure indentation is correct
            $depth -= $minDepth;
            
            
            if ($depth > $prevDepth) {
                // start new ul tag
                if ($ulClass && $depth ==  0) {
                    $ulClass = ' class="' . $ulClass . '"';
                } else {
                    $ulClass = '';
                }
                $html .= '<ul' . $ulClass . '>';
            } else if ($prevDepth > $depth) {
                // close li/ul tags until we're at current depth
                for ($i = $prevDepth; $i > $depth; $i--) {
                    $html .= '</li></ul>';
                }
                // close previous li tag
                $html .= '</li>';
            } else {
                // close previous li tag
                $html .= '</li>';
            }

            // render li tag and page
            $liClass = $isActive ? ' class="active"' : '';
            $html .= '<li' . $liClass . '>'
                   . $this->htmlify($page);

            // store as previous depth for next iteration
            $prevDepth = $depth;
        }

        if ($html) {
            // done iterating container; close open ul/li tags
            for ($i = $prevDepth+1; $i > 0; $i--) {
                $html .= '</li></ul>';
            }
            $html = rtrim($html, self::EOL);
        }

        return $html;
    }
}

?>

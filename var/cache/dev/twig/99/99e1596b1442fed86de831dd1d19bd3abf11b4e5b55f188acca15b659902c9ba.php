<?php

/* rol/edit.html.twig */
class __TwigTemplate_5f74194bf05223d0c6486e0aa64cd94b0a65afd1c63c3bd8cb91dc6ebe103fbf extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("base.html.twig", "rol/edit.html.twig", 1);
        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_9298f5e15fb71b7c28dcb02b06db4e9b3249430fe8ea9285f34e684d127a8340 = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_9298f5e15fb71b7c28dcb02b06db4e9b3249430fe8ea9285f34e684d127a8340->enter($__internal_9298f5e15fb71b7c28dcb02b06db4e9b3249430fe8ea9285f34e684d127a8340_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "rol/edit.html.twig"));

        $__internal_736d908650530e968c833ce750aee6a331abd884bfdfe488e59f437f09494fb5 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_736d908650530e968c833ce750aee6a331abd884bfdfe488e59f437f09494fb5->enter($__internal_736d908650530e968c833ce750aee6a331abd884bfdfe488e59f437f09494fb5_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "rol/edit.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_9298f5e15fb71b7c28dcb02b06db4e9b3249430fe8ea9285f34e684d127a8340->leave($__internal_9298f5e15fb71b7c28dcb02b06db4e9b3249430fe8ea9285f34e684d127a8340_prof);

        
        $__internal_736d908650530e968c833ce750aee6a331abd884bfdfe488e59f437f09494fb5->leave($__internal_736d908650530e968c833ce750aee6a331abd884bfdfe488e59f437f09494fb5_prof);

    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        $__internal_d50bfe6149173e2c11200c03a8a53115ed6ed59c6073f34e1ab6675382ef6dad = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_d50bfe6149173e2c11200c03a8a53115ed6ed59c6073f34e1ab6675382ef6dad->enter($__internal_d50bfe6149173e2c11200c03a8a53115ed6ed59c6073f34e1ab6675382ef6dad_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        $__internal_ef318c6ca3a47650fc438fee6dd97732d10745da53fa5627c8625eeeaf82e620 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_ef318c6ca3a47650fc438fee6dd97732d10745da53fa5627c8625eeeaf82e620->enter($__internal_ef318c6ca3a47650fc438fee6dd97732d10745da53fa5627c8625eeeaf82e620_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 4
        echo "    <h1>Rol edit</h1>

    ";
        // line 6
        echo         $this->env->getRuntime('Symfony\Bridge\Twig\Form\TwigRenderer')->renderBlock((isset($context["edit_form"]) || array_key_exists("edit_form", $context) ? $context["edit_form"] : (function () { throw new Twig_Error_Runtime('Variable "edit_form" does not exist.', 6, $this->getSourceContext()); })()), 'form_start');
        echo "
        ";
        // line 7
        echo $this->env->getRuntime('Symfony\Bridge\Twig\Form\TwigRenderer')->searchAndRenderBlock((isset($context["edit_form"]) || array_key_exists("edit_form", $context) ? $context["edit_form"] : (function () { throw new Twig_Error_Runtime('Variable "edit_form" does not exist.', 7, $this->getSourceContext()); })()), 'widget');
        echo "
        <input type=\"submit\" value=\"Edit\" />
    ";
        // line 9
        echo         $this->env->getRuntime('Symfony\Bridge\Twig\Form\TwigRenderer')->renderBlock((isset($context["edit_form"]) || array_key_exists("edit_form", $context) ? $context["edit_form"] : (function () { throw new Twig_Error_Runtime('Variable "edit_form" does not exist.', 9, $this->getSourceContext()); })()), 'form_end');
        echo "

    <ul>
        <li>
            <a href=\"";
        // line 13
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("rol_index");
        echo "\">Back to the list</a>
        </li>
        <li>
            ";
        // line 16
        echo         $this->env->getRuntime('Symfony\Bridge\Twig\Form\TwigRenderer')->renderBlock((isset($context["delete_form"]) || array_key_exists("delete_form", $context) ? $context["delete_form"] : (function () { throw new Twig_Error_Runtime('Variable "delete_form" does not exist.', 16, $this->getSourceContext()); })()), 'form_start');
        echo "
                <input type=\"submit\" value=\"Delete\">
            ";
        // line 18
        echo         $this->env->getRuntime('Symfony\Bridge\Twig\Form\TwigRenderer')->renderBlock((isset($context["delete_form"]) || array_key_exists("delete_form", $context) ? $context["delete_form"] : (function () { throw new Twig_Error_Runtime('Variable "delete_form" does not exist.', 18, $this->getSourceContext()); })()), 'form_end');
        echo "
        </li>
    </ul>
";
        
        $__internal_ef318c6ca3a47650fc438fee6dd97732d10745da53fa5627c8625eeeaf82e620->leave($__internal_ef318c6ca3a47650fc438fee6dd97732d10745da53fa5627c8625eeeaf82e620_prof);

        
        $__internal_d50bfe6149173e2c11200c03a8a53115ed6ed59c6073f34e1ab6675382ef6dad->leave($__internal_d50bfe6149173e2c11200c03a8a53115ed6ed59c6073f34e1ab6675382ef6dad_prof);

    }

    public function getTemplateName()
    {
        return "rol/edit.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  80 => 18,  75 => 16,  69 => 13,  62 => 9,  57 => 7,  53 => 6,  49 => 4,  40 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends 'base.html.twig' %}

{% block body %}
    <h1>Rol edit</h1>

    {{ form_start(edit_form) }}
        {{ form_widget(edit_form) }}
        <input type=\"submit\" value=\"Edit\" />
    {{ form_end(edit_form) }}

    <ul>
        <li>
            <a href=\"{{ path('rol_index') }}\">Back to the list</a>
        </li>
        <li>
            {{ form_start(delete_form) }}
                <input type=\"submit\" value=\"Delete\">
            {{ form_end(delete_form) }}
        </li>
    </ul>
{% endblock %}
", "rol/edit.html.twig", "C:\\xampp\\htdocs\\Proyecto\\app\\Resources\\views\\rol\\edit.html.twig");
    }
}

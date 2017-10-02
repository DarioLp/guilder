<?php

/* :token:index.html.twig */
class __TwigTemplate_f5d87b2d4d8502a4d9635cefd5eeaab57f24af782169244369939ae5f091f93c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("base.html.twig", ":token:index.html.twig", 1);
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
        $__internal_b0618544063cb1377ec0e895e6c61285a242d057edd023385a4b2161f687302d = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_b0618544063cb1377ec0e895e6c61285a242d057edd023385a4b2161f687302d->enter($__internal_b0618544063cb1377ec0e895e6c61285a242d057edd023385a4b2161f687302d_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", ":token:index.html.twig"));

        $__internal_44ff033fc30bd6b8874224ce6d1844d52524c164f422283b26228a66ce81002e = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_44ff033fc30bd6b8874224ce6d1844d52524c164f422283b26228a66ce81002e->enter($__internal_44ff033fc30bd6b8874224ce6d1844d52524c164f422283b26228a66ce81002e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", ":token:index.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_b0618544063cb1377ec0e895e6c61285a242d057edd023385a4b2161f687302d->leave($__internal_b0618544063cb1377ec0e895e6c61285a242d057edd023385a4b2161f687302d_prof);

        
        $__internal_44ff033fc30bd6b8874224ce6d1844d52524c164f422283b26228a66ce81002e->leave($__internal_44ff033fc30bd6b8874224ce6d1844d52524c164f422283b26228a66ce81002e_prof);

    }

    // line 5
    public function block_body($context, array $blocks = array())
    {
        $__internal_fce3e6d5ec839b933dab9fd30e635cec660162902feb737829e816f739ca6514 = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_fce3e6d5ec839b933dab9fd30e635cec660162902feb737829e816f739ca6514->enter($__internal_fce3e6d5ec839b933dab9fd30e635cec660162902feb737829e816f739ca6514_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        $__internal_578ff7469035f3a9afa4c96632181508e4957071ede65ea61372a86f10d96e6e = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_578ff7469035f3a9afa4c96632181508e4957071ede65ea61372a86f10d96e6e->enter($__internal_578ff7469035f3a9afa4c96632181508e4957071ede65ea61372a86f10d96e6e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 6
        echo "

<h1>Lista de tokens</h1>

";
        // line 10
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["app"] ?? $this->getContext($context, "app")), "flashes", array(0 => "tokencreado"), "method"));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 11
            echo "\t<div class=\"alert alert-success\">
  <strong>Éxito</strong> El token ha sido creado con el código ";
            // line 12
            echo twig_escape_filter($this->env, $context["message"], "html", null, true);
            echo ".
    </div>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['message'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 15
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["app"] ?? $this->getContext($context, "app")), "flashes", array(0 => "tokeneliminado"), "method"));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 16
            echo "\t<div class=\"alert alert-danger\">
  El token ha sido eliminado.
    </div>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['message'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 20
        echo "<div class=\"center-block\" style=\"max-width:400px\">
\t<a href=\"";
        // line 21
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("token_new");
        echo "\" class=\"btn btn-success btn-lg\">
\t<span class=\"glyphicon glyphicon-plus\"></span> Crear nuevo token 
\t</a>
</div>

\t
\t<table class=\"table table-bordered\">
    <thead>
      <tr>
        <th><p class=\"text-center\">Token</p></th>
        <th><p class=\"text-center\">Fecha de creación</p></th>
        <th><p class=\"text-center\">Acciones</p></th>
      </tr>
    </thead>
    <tbody>
      ";
        // line 36
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["tokens"] ?? $this->getContext($context, "tokens")));
        foreach ($context['_seq'] as $context["_key"] => $context["token"]) {
            // line 37
            echo "            <tr>
\t\t\t\t<td>";
            // line 38
            echo twig_escape_filter($this->env, $this->getAttribute($context["token"], "token", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 39
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($context["token"], "creado", array()), "Y-m-d H:i"), "html", null, true);
            echo "</td>
\t\t\t\t<td><a href=\"";
            // line 40
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("token_delete", array("idtoken" => $this->getAttribute($context["token"], "idtoken", array()))), "html", null, true);
            echo "\" class=\"btn\"><span class=\"glyphicon glyphicon-trash\"></span> Eliminar</a></td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['token'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 43
        echo "    </tbody>
  </table>
\t


    
";
        
        $__internal_578ff7469035f3a9afa4c96632181508e4957071ede65ea61372a86f10d96e6e->leave($__internal_578ff7469035f3a9afa4c96632181508e4957071ede65ea61372a86f10d96e6e_prof);

        
        $__internal_fce3e6d5ec839b933dab9fd30e635cec660162902feb737829e816f739ca6514->leave($__internal_fce3e6d5ec839b933dab9fd30e635cec660162902feb737829e816f739ca6514_prof);

    }

    public function getTemplateName()
    {
        return ":token:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  129 => 43,  120 => 40,  116 => 39,  112 => 38,  109 => 37,  105 => 36,  87 => 21,  84 => 20,  75 => 16,  71 => 15,  62 => 12,  59 => 11,  55 => 10,  49 => 6,  40 => 5,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends 'base.html.twig' %}



{% block body %}


<h1>Lista de tokens</h1>

{% for message in app.flashes('tokencreado') %}
\t<div class=\"alert alert-success\">
  <strong>Éxito</strong> El token ha sido creado con el código {{ message }}.
    </div>
{% endfor %}
{% for message in app.flashes('tokeneliminado') %}
\t<div class=\"alert alert-danger\">
  El token ha sido eliminado.
    </div>
{% endfor %}
<div class=\"center-block\" style=\"max-width:400px\">
\t<a href=\"{{ path('token_new') }}\" class=\"btn btn-success btn-lg\">
\t<span class=\"glyphicon glyphicon-plus\"></span> Crear nuevo token 
\t</a>
</div>

\t
\t<table class=\"table table-bordered\">
    <thead>
      <tr>
        <th><p class=\"text-center\">Token</p></th>
        <th><p class=\"text-center\">Fecha de creación</p></th>
        <th><p class=\"text-center\">Acciones</p></th>
      </tr>
    </thead>
    <tbody>
      {% for token in tokens %}
            <tr>
\t\t\t\t<td>{{ token.token }}</td>
                <td>{{ token.creado|date('Y-m-d H:i') }}</td>
\t\t\t\t<td><a href=\"{{ path('token_delete', { 'idtoken': token.idtoken }) }}\" class=\"btn\"><span class=\"glyphicon glyphicon-trash\"></span> Eliminar</a></td>
            </tr>
        {% endfor %}
    </tbody>
  </table>
\t


    
{% endblock %}
", ":token:index.html.twig", "C:\\xampp\\htdocs\\Proyecto\\app/Resources\\views/token/index.html.twig");
    }
}

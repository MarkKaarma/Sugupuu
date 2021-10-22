<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
   "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head runat="server">
        <title>Elisaveth II sugupuu leht</title>
    </head>
    <form id="form1" runat="server">
        <div>
            <asp:Xml ID="xml1" runat="server"
                DocumentSource="~/Elisaveta2.xml"
                TransformSource="~/sugupuuElisa.xslt" /> 
        </div>
    </form>


</html>
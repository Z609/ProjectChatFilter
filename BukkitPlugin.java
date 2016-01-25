
import org.bukkit.Bukkit;
import org.bukkit.entity.Player;
import org.bukkit.event.EventHandler;
import org.bukkit.event.EventPriority;
import org.bukkit.event.Listener;
import org.bukkit.event.player.AsyncPlayerChatEvent;
import org.bukkit.plugin.java.JavaPlugin;
import org.json.JSONException;

import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.URL;

/**
 * @author Z609
 */
public class BukkitPlugin extends JavaPlugin implements Listener {
    
    @Override
    public void onEnable(){
        getServer().getPluginManager().registerEvents(this, this);
    }

    @EventHandler(priority = EventPriority.MONITOR)
    public void onChat(AsyncPlayerChatEvent event){
        if(event.isCancelled()){
            return;
        }

        event.setCancelled(true);
        Player player = event.getPlayer();
        String message = event.getMessage();

        try {
            String safeUrl = "https://api.z609.me/censor/?message=" + message.replace(" ", "%20");
            URL url = new URL(safeUrl);
            HttpURLConnection conn = (HttpURLConnection)url.openConnection();
            conn.addRequestProperty("User-Agent", "Mozilla/4.76");
            InputStream in = conn.getInputStream();
            String encoding = conn.getContentEncoding();
            encoding = encoding == null ? "UTF-8" : encoding;
            ByteArrayOutputStream out = new ByteArrayOutputStream();
            byte[] bytes = new byte[8192];
            int len = 0;
            while((len = in.read(bytes)) != -1){
                out.write(bytes, 0, len);
            }
            String content = "[" + new String(out.toByteArray(), encoding) + "]";
            org.json.JSONArray json = new org.json.JSONArray(content);
            int profanityLevel = 0;
            int status = 0;
            for(int i = 0; i < json.length(); i++){
                status = json.getJSONObject(i).getInt("status");
                if(status == 1){
                    message = json.getJSONObject(i).getString("reponse");
                    profanityLevel = json.getJSONObject(i).getInt("profanityLevel");
                }
            }
            if(profanityLevel>5){
                player.kickPlayer("Watch your profanity!");
                return;
            }
        } catch (IOException ignored) {
        } catch (JSONException ignored) {
        }

        Bukkit.broadcastMessage(player.getDisplayName() + ": " + message);
    }

}

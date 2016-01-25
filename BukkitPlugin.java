
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
 * Required dependency: https://github.com/douglascrockford/JSON-java (place in org.json)
 */
public class BukkitPlugin extends JavaPlugin implements Listener {
    
    @Override
    public void onEnable(){
		// Make sure that the onChat method gets fired
        getServer().getPluginManager().registerEvents(this, this);
    }

    @EventHandler(priority = EventPriority.MONITOR) // For muting plugins
    public void onChat(AsyncPlayerChatEvent event){
        if(event.isCancelled()){ // For muting plugins
            return;
        }

        event.setCancelled(true); // To prevent the default chat message from showing
        Player player = event.getPlayer(); // Get the player sending the message
        String message = event.getMessage(); // Get the actual message

        try {
			// Get the "safe url", you need to use %20, not just regular spaces
            String safeUrl = "https://api.z609.me/censor/?message=" + message.replace(" ", "%20"); 
			
			// Create a new URL object
            URL url = new URL(safeUrl); 
			
			// Open the connection the url
            HttpURLConnection conn = (HttpURLConnection)url.openConnection(); 
			
			// Set the user agent
            conn.addRequestProperty("User-Agent", "Mozilla/4.76");
			
			// Initialize an Input Stream which will be used to get the content of the page
            InputStream in = conn.getInputStream();
			
			// Get the text encoding type.
            String encoding = conn.getContentEncoding(); 
			
			// Just in case the encoding has not been set, the encoding will actually be set to UTF-8.
            encoding = encoding == null ? "UTF-8" : encoding; 
			
            ByteArrayOutputStream out = new ByteArrayOutputStream();
            byte[] bytes = new byte[8192];
            int len = 0;
            while((len = in.read(bytes)) != -1){
                out.write(bytes, 0, len);
            }
			
			// Use the encoding type we got earlier to put it into a stream. Wrap it around in the bracket things for JSON parsing
            String content = "[" + new String(out.toByteArray(), encoding) + "]";
			
			// Make a JSONArray
            org.json.JSONArray json = new org.json.JSONArray(content);
			
            int profanityLevel = 0;
            int status = 0;
			
			// Loop through the results of the JSON array
            for(int i = 0; i < json.length(); i++){
				
				// Get the status variable
                status = json.getJSONObject(i).getInt("status");
				
				// Make sure no errors popped up
                if(status==1){
					
					// Set the message that the player sent to the filtered version
                    message = json.getJSONObject(i).getString("reponse");
					
					// Set the profanity level of that message 
                    profanityLevel = json.getJSONObject(i).getInt("profanityLevel");
					
                }
            }
			
			// Just something in case they use too much profanity
            if(profanityLevel>=5){
                player.kickPlayer("Watch your profanity!");
                return;
            }
			
        } catch (IOException ignored) {
        } catch (JSONException ignored) {
        }

		// Broadcast the chat message
        Bukkit.broadcastMessage(player.getDisplayName() + ": " + message);
    }

}
